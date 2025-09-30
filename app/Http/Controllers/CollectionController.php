<?php

namespace App\Http\Controllers;

use App\Services\BadgeService;
use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\Post;
use App\Models\Badge;

class CollectionController extends Controller
{
    
    public function index()
    {
        $collections = auth()->user()->collections()->with('posts')->get();
        return view('collections.index', compact('collections'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:5120', 
        ]);

        
        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('collections', 'public');
            $data['image'] = $path;
        }

        
        $collection = $request->user()->collections()->create($data);

        
        app(\App\Services\BadgeService::class)->checkAndAssign($request->user());

        return redirect()->route('collections.index')->with('success', 'Collection created!');
    }

    
    public function show(Collection $collection)
    {
        if ($collection->user_id !== auth()->id()) abort(403);

        $collection->load('posts');
        return view('collections.show', compact('collection'));
    }

    
    public function update(Request $request, Collection $collection)
    {
        if ($collection->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        
        if ($request->hasFile('image')) {
            
            if ($collection->image) {
                \Storage::disk('public')->delete($collection->image);
            }

            
            $validated['image'] = $request->file('image')->store('collections', 'public');
        }

        
        $collection->update($validated);

        return redirect()->route('collections.index')->with('success', 'Collection updated!');
    }


   
    public function destroy(Collection $collection)
    {
        if ($collection->user_id !== auth()->id()) abort(403);

        $collection->delete();
        return redirect()->route('collections.index')->with('success', 'Collection deleted!');
    }

    
    public function removePost(Collection $collection, Post $post)
    {
        if ($collection->user_id !== auth()->id()) abort(403);

        $collection->posts()->detach($post->id);
        return back()->with('success', 'Post removed from collection.');
    }

    
    public function addPost(Request $request, Post $post)
    {
        $request->validate([
            'collection' => 'required|exists:collections,id',
        ]);

        $collection = Collection::findOrFail($request->collection);
        $collection->posts()->syncWithoutDetaching($post->id);

        return back()->with('success', 'Post added to collection!');
    }
}
