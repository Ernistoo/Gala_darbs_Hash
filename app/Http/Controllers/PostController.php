<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Services\BadgeService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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
            'title'       => 'required|string|max:255',
            'content'     => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'category_id' => 'required|exists:categories,id',
            'youtube_url' => 'nullable|url',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        if ($data['youtube_url']) {
            if (preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $data['youtube_url'], $matches)) {
                $data['youtube_thumbnail'] = "https://img.youtube.com/vi/{$matches[1]}/hqdefault.jpg";
            }
        }

        if (!$request->hasFile('image') && !$request->filled('youtube_url')) {
            return back()
                ->withErrors(['media' => 'You must upload an image or provide a YouTube URL.'])
                ->withInput();
        }
        $data['user_id'] = auth()->id();

        Post::create($data);

        app(\App\Services\BadgeService::class)->checkAndAssign($request->user());

        return redirect()->route(
            session('last_category_id')
                ? 'posts.byCategory'
                : 'posts.index',
            session('last_category_id') ?? []
        )->with('success', 'Post created successfully!');
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
            'title'       => 'required|string|max:255',
            'content'     => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'category_id' => 'required|exists:categories,id',
            'youtube_url' => 'nullable|url',
        ]);


        if ($request->hasFile('image')) {
            if ($post->image && file_exists(storage_path('app/public/' . $post->image))) {
                unlink(storage_path('app/public/' . $post->image));
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        if (!$request->hasFile('image') && !$request->filled('youtube_url')) {
            return back()
                ->withErrors(['media' => 'You must upload an image or provide a YouTube URL.'])
                ->withInput();
        }

        $post->update($data);

        return redirect()->route('posts.show', $post)->with('success', 'Post updated successfully!');
    }


    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->image && file_exists(storage_path('app/public/' . $post->image))) {
            unlink(storage_path('app/public/' . $post->image));
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
                'liked' => true,
                'likes_count' => $post->likes()->count()
            ]);
        }

        return back();
    }

    public function unlike(Post $post)
    {
        $post->likes()->where('user_id', auth()->id())->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'liked' => false,
                'likes_count' => $post->likes()->count()
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
}
