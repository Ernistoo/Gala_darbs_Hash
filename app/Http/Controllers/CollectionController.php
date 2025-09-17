<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\Post;
use App\Models\Badge;

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

    // Izveido kolekciju
    $collection = $request->user()->collections()->create([
        'name' => $request->name,
    ]);

    // Pārbauda, vai tas ir pirmā kolekcija
    if ($request->user()->collections()->count() === 1) {
        // Izveido vai saņem badge
        $badge = \App\Models\Badge::firstOrCreate(
            ['name' => 'First Collection'],
            [
                'image' => 'default-avatar.png',
                'description' => 'Created your first collection!'
            ]
        );

        // Piešķir badge lietotājam, ja vēl nav
        if (!$request->user()->badges->contains($badge->id)) {
            $request->user()->badges()->attach($badge->id);
            $badgeAwarded = true;
        } else {
            $badgeAwarded = false;
        }

        // Nosūta flag JS popup animācijai
        session()->flash('badge_earned', $badgeAwarded);
        session()->flash('badge_image', $badge->image);
        session()->flash('badge_name', $badge->name);
    }

    return redirect()->route('collections.index')->with('success', 'Collection created!');
}


    public function addPost(Request $request, $collectionId, Post $post)
{
    $collection = Collection::findOrFail($request->input('collection'));

    
    if ($collection->user_id !== auth()->id()) {
        abort(403);
    }

    $collection->posts()->attach($post->id);

    return back()->with('success', 'Post added to collection!');
}
}
