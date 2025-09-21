<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\Post;
use App\Models\Badge;

class CollectionController extends Controller
{
    // Rāda visas lietotāja kolekcijas
    public function index()
    {
        $collections = auth()->user()->collections()->with('posts')->get();
        return view('collections.index', compact('collections'));
    }

    // Izveido jaunu kolekciju
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:2048', // opcija ierobežo faila lielumu
        ]);

        // Sagatavo dati
        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        // Ja augšupielādēts attēls
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('collections', 'public');
            $data['image'] = $path;
        }

        // Izveido kolekciju
        $collection = $request->user()->collections()->create($data);

        // Badge piešķiršana, ja tas ir pirmā kolekcija
        if ($request->user()->collections()->count() === 1) {
            $badge = Badge::firstOrCreate(
                ['name' => 'First Collection'],
                ['image' => 'award.jpg', 'description' => 'Created your first collection!']
            );

            if (!$request->user()->badges->contains($badge->id)) {
                $request->user()->badges()->attach($badge->id);
                session()->flash('badge_earned', true);
                session()->flash('badge_image', $badge->image);
                session()->flash('badge_name', $badge->name);
                session()->flash('badge_description', $badge->description);
            }
        }

        return redirect()->route('collections.index')->with('success', 'Collection created!');
    }

    // Skatīt vienu kolekciju un tās postus
    public function show(Collection $collection)
    {
        if ($collection->user_id !== auth()->id()) abort(403);

        $collection->load('posts');
        return view('collections.show', compact('collection'));
    }

    // Update kolekciju (modal no index)
    public function update(Request $request, Collection $collection)
    {
        if ($collection->user_id !== auth()->id()) abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $collection->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('collections.index')->with('success', 'Collection updated!');
    }

    // Dzēst kolekciju (modal no index)
    public function destroy(Collection $collection)
    {
        if ($collection->user_id !== auth()->id()) abort(403);

        $collection->delete();
        return redirect()->route('collections.index')->with('success', 'Collection deleted!');
    }

    // Dzēst postu no kolekcijas
    public function removePost(Collection $collection, Post $post)
    {
        if ($collection->user_id !== auth()->id()) abort(403);

        $collection->posts()->detach($post->id);
        return back()->with('success', 'Post removed from collection.');
    }

    // Pievienot postu kolekcijai
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
