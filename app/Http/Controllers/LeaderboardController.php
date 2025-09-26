<?php

namespace App\Http\Controllers;

use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('xp')->take(50)->get();

        return view('leaderboard.index', compact('users'));
    }
}
