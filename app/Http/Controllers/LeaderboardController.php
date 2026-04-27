<?php

namespace App\Http\Controllers;

use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
{
    $users = User::orderBy('xp', 'desc')
                ->orderBy('id', 'asc') 
                ->paginate(10);
    
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
