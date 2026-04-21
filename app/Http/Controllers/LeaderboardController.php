<?php

namespace App\Http\Controllers;

use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
{
    $users = User::orderBy('xp', 'desc')
                ->orderBy('id', 'asc') // Tiebreaker
                ->paginate(10);
    
    // Calculate current user's rank
    $userRank = null;
    if (auth()->check()) {
        $userRank = User::where('xp', '>', auth()->user()->xp)
                       ->orWhere(function ($query) {
                           $query->where('xp', auth()->user()->xp)
                                 ->where('id', '<', auth()->id());
                       })
                       ->count() + 1;
    }
    
    $totalUsers = User::count();
    
    return view('leaderboard.index', compact('users', 'userRank', 'totalUsers'));
}
}
