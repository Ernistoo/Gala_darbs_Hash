<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\MentionNotification;

class MentionController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');

        $users = User::where('username', 'like', "%{$query}%")
            ->take(5)
            ->get(['id', 'username', 'name', 'profile_photo']);

        return response()->json($users);
    }
}