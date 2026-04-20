<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Services\BadgeService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Post::query()->latest();

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $posts = $query->get();

        return view('posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        $defaultCategoryId = session('last_category_id');

        return view('posts.create', compact('categories', 'defaultCategoryId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'                => 'required|string|max:255',
            'content'              => 'nullable|string',
            'image'                => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'video'                => 'nullable|mimes:mp4,mov,avi,wmv,flv,mkv,webm|max:51200',
            'category_id'          => 'required|exists:categories,id',
            'youtube_url'          => 'nullable|url',
            'video_thumbnail_data' => 'nullable|string', // Base64 data from frontend
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        // Handle video upload + thumbnail (client‑side generated)
        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('posts/videos', 'public');
            
            // Save manual thumbnail if provided
            if ($request->hasFile('video_thumbnail')) {
                $data['video_thumbnail'] = $request->file('video_thumbnail')->store('posts/thumbnails', 'public');
            }
        }

        // Handle YouTube URL
        if (!empty($data['youtube_url'])) {
            if (preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $data['youtube_url'], $matches)) {
                $data['youtube_thumbnail'] = "https://img.youtube.com/vi/{$matches[1]}/hqdefault.jpg";
            }
        }

        // Validate at least one media type is provided
        if (!$request->hasFile('image') && !$request->hasFile('video') && !$request->filled('youtube_url')) {
            return back()
                ->withErrors(['media' => 'You must upload an image, video, or provide a YouTube URL.'])
                ->withInput();
        }

        $data['user_id'] = auth()->id();

        Post::create($data);

        app(\App\Services\BadgeService::class)->checkAndAssign($request->user());

        return redirect()->route(
            session('last_category_id') ? 'posts.byCategory' : 'posts.index',
            session('last_category_id') ?? []
        )->with('success', 'Post created successfully!');
        dd($request->all());
        }

    public function show(Post $post)
    {
        $comments = $post->comments()
            ->whereNull('parent_id')
            ->with(['user', 'replies.user'])
            ->latest()
            ->get();

        return view('posts.show', compact('post', 'comments'));
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();

        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'title'                => 'required|string|max:255',
            'content'              => 'nullable|string',
            'image'                => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'video'                => 'nullable|mimes:mp4,mov,avi,wmv,flv,mkv,webm|max:51200',
            'category_id'          => 'required|exists:categories,id',
            'youtube_url'          => 'nullable|url',
            'video_thumbnail_data' => 'nullable|string',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        // Handle video upload
        if ($request->hasFile('video')) {
            // Delete old video
            if ($post->video) Storage::disk('public')->delete($post->video);
            $data['video'] = $request->file('video')->store('posts/videos', 'public');
            
            // If a new thumbnail is uploaded, delete old and save new
            if ($request->hasFile('video_thumbnail')) {
                if ($post->video_thumbnail) Storage::disk('public')->delete($post->video_thumbnail);
                $data['video_thumbnail'] = $request->file('video_thumbnail')->store('posts/thumbnails', 'public');
            }
        } else {
            // If only thumbnail is updated without new video, still allow updating thumbnail
            if ($request->hasFile('video_thumbnail')) {
                if ($post->video_thumbnail) Storage::disk('public')->delete($post->video_thumbnail);
                $data['video_thumbnail'] = $request->file('video_thumbnail')->store('posts/thumbnails', 'public');
            }
        }

        // Handle YouTube URL
        if (!empty($data['youtube_url'])) {
            if (preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $data['youtube_url'], $matches)) {
                $data['youtube_thumbnail'] = "https://img.youtube.com/vi/{$matches[1]}/hqdefault.jpg";
            }
        }

        $post->update($data);

        return redirect()->route('posts.show', $post)->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        if ($post->video && Storage::disk('public')->exists($post->video)) {
            Storage::disk('public')->delete($post->video);
        }

        if ($post->video_thumbnail && Storage::disk('public')->exists($post->video_thumbnail)) {
            Storage::disk('public')->delete($post->video_thumbnail);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }

    public function like(Post $post)
    {
        if (!$post->likedBy(auth()->user())) {
            $post->likes()->create(['user_id' => auth()->id()]);
        }

        if (request()->wantsJson()) {
            return response()->json([
                'liked'       => true,
                'likes_count' => $post->likes()->count(),
            ]);
        }

        return back();
    }

    public function unlike(Post $post)
    {
        $post->likes()->where('user_id', auth()->id())->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'liked'       => false,
                'likes_count' => $post->likes()->count(),
            ]);
        }

        return back();
    }

    public function byCategory($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        session(['last_category_id' => $id]);

        $posts = $category->posts()->latest()->get();

        return view('posts.category', compact('category', 'posts'));
    }

    /**
     * Save a Base64 encoded image as a video thumbnail.
     *
     * @param string|null $base64Data
     * @param string      $videoPath
     * @return string|null
     */
    private function saveBase64Thumbnail($base64Data, $videoPath)
    {
        if (!$base64Data) {
            return null;
        }

        // Extract the image data
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Data, $type)) {
            $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
            $type = strtolower($type[1]); // jpeg, png, etc.
            if (!in_array($type, ['jpg', 'jpeg', 'png'])) {
                $type = 'jpg';
            }
            $base64Data = base64_decode($base64Data);
            if ($base64Data === false) {
                return null;
            }

            $thumbDir = storage_path('app/public/posts/thumbnails');
            if (!file_exists($thumbDir)) {
                mkdir($thumbDir, 0755, true);
            }

            $thumbnailName = pathinfo($videoPath, PATHINFO_FILENAME) . '_thumb.' . $type;
            $thumbnailPath = 'posts/thumbnails/' . $thumbnailName;
            file_put_contents(storage_path('app/public/' . $thumbnailPath), $base64Data);

            return $thumbnailPath;
        }

        return null;
    }
}