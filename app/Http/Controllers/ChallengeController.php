<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChallengeController extends Controller
{
    public function index()
    {
        $challenges = Challenge::where('deadline', '>', now()) // tikai aktīvie
            ->withCount(['submissions as participants_count' => function ($query) {
                $query->select(DB::raw('COUNT(DISTINCT user_id)'));
            }])->get();

        return view('challenges.index', compact('challenges'));
    }

    public function show(Challenge $challenge)
    {
        $challenge->loadCount([
            'submissions as participants_count' => function ($query) {
                $query->select(DB::raw('COUNT(DISTINCT user_id)'));
            }
        ]);

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
            'image' => 'nullable|image|max:2048', // validācija
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
            'deadline' => now()->addWeek(),
        ]);

        return redirect()->route('challenges.index')->with('success', 'Challenge created!');
    }
}
