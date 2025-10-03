<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChallengeController extends Controller
{
    public function index()
{
    $challenges = Challenge::where('deadline', '>', now()) 
        ->withCount([
            'submissions as participants_count' => fn($q) => $q->select(DB::raw('COUNT(DISTINCT user_id)'))
        ])
        ->get();

    return view('challenges.index', compact('challenges'));
}

public function show(Challenge $challenge)
{
    if ($challenge->deadline && $challenge->deadline->isPast()) {
        return redirect()->route('challenges.index')
            ->with('error', 'This challenge has ended.');
    }

    $challenge->loadCount([
        'submissions as participants_count' => fn($q) => $q->select(DB::raw('COUNT(DISTINCT user_id)'))
    ])->load(['winnerSubmission.user']);

    return view('challenges.show', compact('challenge'));
}

    public function create()
    {
        return view('challenges.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:5120', 
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('challenges', 'public');
        }

        Challenge::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $path,
            'start_date' => now(),
            'deadline' => now()->addMinute(),
        ]);

        return redirect()->route('challenges.index')->with('success', 'Challenge created!');
    }

    public function destroy(Challenge $challenge)
{
    if (!auth()->user()->hasRole('admin')) {
        abort(403);
    }

    
    if ($challenge->image && \Storage::disk('public')->exists($challenge->image)) {
        \Storage::disk('public')->delete($challenge->image);
    }

    $challenge->delete();

    return redirect()->route('challenges.index')->with('success', 'Challenge deleted successfully!');
}
}
