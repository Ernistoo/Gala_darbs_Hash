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

    public function destroy(User $user)
{
    $this->authorize('delete', $user);

    
    $user->posts()->delete();

    
    $user->delete();

    return redirect()->route('dashboard')->with('success', 'Lietotājs veiksmīgi dzēsts.');
}
}
