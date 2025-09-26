<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        // Šeit pagaidām tikai atgriežam atpakaļ (vēlāk var likt DB vai events)
        return response()->json([
            'user' => Auth::user()->name,
            'message' => $request->message,
        ]);
    }
}
