<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index(Challenge $challenge)
    {
        $sort = request('sort');

        $submissions = $challenge->submissions()
            ->with('user')
            ->withCount('votes');

        if ($sort === 'most_voted') {
            $submissions->orderByDesc('votes_count');
        } elseif ($sort === 'least_voted') {
            $submissions->orderBy('votes_count');
        } elseif ($sort === 'latest') {
            $submissions->latest();
        } else {
            $submissions->latest();
        }

        $submissions = $submissions->get();

        return view('submissions.index', compact('challenge', 'submissions'));
    }

    public function store(Request $request, Challenge $challenge)
    {
        $request->validate([
            'image' => 'required|image|max:5120'
        ]);

        $path = $request->file('image')->store('submissions', 'public');

        Submission::create([
            'challenge_id' => $challenge->id,
            'user_id' => auth()->id(),
            'image' => $path
        ]);

        $user = auth()->user();
    $user->increment('xp', 1);

    return redirect()->route('challenges.show', $challenge)
        ->with('success', 'Submission created! +1 XP');
    
    }
}
