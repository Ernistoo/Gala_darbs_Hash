<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Support\Facades\DB;

class ChallengeController extends Controller
{
    public function index()
    {
        $challenges = Challenge::withCount(['submissions as participants_count' => function ($query) {
            $query->select(\DB::raw('COUNT(DISTINCT user_id)'));
        }])->get();
        return view('challenges.index', compact('challenges'));
    }

    public function show(Challenge $challenge)
    {
        $challenge->loadCount([
            'submissions as participants_count' => function ($query) {
                $query->select(\DB::raw('COUNT(DISTINCT user_id)'));
            }
        ]);

        return view('challenges.show', compact('challenge'));
    }
}
