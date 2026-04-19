<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Collection;


class SearchController extends Controller
{
    public function index()
    {
        return view('search.index');
    }

    public function ajax(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (strlen($query) < 2) {
            return response()->json([
                'users' => [],
                'categories' => []
            ]);
        }

        $users = User::query()
            ->where('name', 'like', "%{$query}%")
            ->orWhere('username', 'like', "%{$query}%")
            ->take(5)
            ->get(['id', 'name', 'username', 'profile_photo']);

        $categories = Category::query()
            ->where('name', 'like', "%{$query}%")
            ->take(5)
            ->get(['id', 'name', 'image']);

        return response()->json([
            'users' => $users,
            'categories' => $categories,
        ]);
    }
    public function posts(Request $request)
    {
        $query = $request->get('q', '');
        $posts = Post::where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->with('user')
            ->latest()
            ->limit(20)
            ->get();

        return response()->json($posts->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'image' => $post->image ? asset('storage/' . $post->image) : null,
                'user' => $post->user->name,
                'url' => route('posts.show', $post),
            ];
        }));
    }

    public function collections(Request $request)
    {
        $query = $request->get('q', '');
        $collections = Collection::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->with('user')
            ->latest()
            ->limit(20)
            ->get();

        return response()->json($collections->map(function ($collection) {
            return [
                'id' => $collection->id,
                'name' => $collection->name,
                'image' => $collection->image ? asset('storage/' . $collection->image) : null,
                'user' => $collection->user->name,
                'url' => route('collections.show', $collection),
            ];
        }));
    }
}
