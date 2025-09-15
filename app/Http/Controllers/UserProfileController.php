<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserProfileController extends Controller
{
    public function show(User $user)
    {
        $posts = $user->posts()->latest()->get();

        return view('users.show', compact('user', 'posts'));
    }
}
