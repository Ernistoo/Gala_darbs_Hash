<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\GenericNotification;

class FriendshipController extends Controller
{
    public function index()
{
    $friends = auth()->user()->allFriends();
    return view('friends.index', compact('friends'));
}

public function send(User $user)
{
    if (auth()->id() === $user->id) {
        return back()->with('error', 'You cannot add yourself as a friend.');
    }

    Friendship::firstOrCreate([
        'user_id'   => auth()->id(),
        'friend_id' => $user->id,
    ]);

    $user->notify(
        new GenericNotification(auth()->user()->name . " sent you a friend request", auth()->user())
    );

    return back()->with('success', 'Friend request sent!');
}

    public function accept(Friendship $friendship)
    {
        if ($friendship->friend_id !== auth()->id()) {
            abort(403);
        }

        $friendship->update(['status' => 'accepted']);

        $friendship->user->notify(
            new GenericNotification(auth()->user()->name . " accepted your friend request", auth()->user())
        );

        return back()->with('success', 'Friend request accepted!');
    }
}
