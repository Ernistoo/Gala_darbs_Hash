<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function store(Request $request, Challenge $challenge)
    {
        $request->validate([
            'image' => 'required|image|max:2048'
        ]);

        $path = $request->file('image')->store('submissions', 'public');

        Submission::create([
            'challenge_id' => $challenge->id,
            'user_id' => auth()->id(),
            'image' => $path
        ]);

        return redirect()->route('challenges.show', $challenge)->with('success', 'Iesniegts veiksmīgi!');
    }

    public function index(Challenge $challenge)
    {
        $submissions = $challenge->submissions()->with('user')->latest()->get();
        return view('submissions.index', compact('challenge', 'submissions'));
    }
}
