<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\Post;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = auth()->user()->collections()->with('posts')->get();
        return view('collections', compact('collections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        auth()->user()->collections()->create([
            'name' => $request->name,
        ]);

        return redirect()->route('collections.index')->with('success', 'Collection created!');
    }

    public function addPost(Collection $collection, Post $post)
    {
        if ($collection->user_id !== auth()->id()) {
            abort(403);
        }

        $collection->posts()->syncWithoutDetaching([$post->id]);

        return back()->with('success', 'Post added to collection!');
    }
}
