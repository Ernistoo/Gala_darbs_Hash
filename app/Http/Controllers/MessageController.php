<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return Message::with('user')
            ->latest()
            ->take(20) // pēdējās 20 ziņas
            ->get()
            ->reverse()
            ->values();
    }

    public function store(Request $request)
    {
        $request->validate(['content' => 'required|string|max:500']);

        $message = Message::create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return $message->load('user');
    }
}

