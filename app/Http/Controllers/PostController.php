<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
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
        $categories = Category::all();
        return view('posts.create', compact('categories'));
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

        $data['user_id'] = auth()->id();

        Post::create($data);

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }


    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
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

        $post->update($data);

        return redirect()->route('posts.show', $post)->with('success', 'Post updated successfully!');
    }


    public function destroy(Post $post)
    {
        $this->authorize('delete', $post); // policy nosaka, vai admins vai owner

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

        return back();
    }


    public function unlike(Post $post)
    {
        $post->likes()->where('user_id', auth()->id())->delete();
        return back();
    }
}
