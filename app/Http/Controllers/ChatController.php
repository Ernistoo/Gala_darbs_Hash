<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Post;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\MessageReceived;

class ChatController extends Controller
{
    // Get chat history with a specific friend
    public function index(User $user)
    {
        $authUserId = Auth::id();

        // Fetch conversation between auth user and selected friend
        $messages = Message::where(function ($query) use ($user, $authUserId) {
            $query->where('sender_id', $authUserId)
                ->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($user, $authUserId) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', $authUserId);
        })->orderBy('created_at')->get();

        // Mark unread messages as read
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $authUserId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'friend' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'profile_photo' => $user->profile_photo,
            ],
            'messages' => $messages->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'sender_id' => $msg->sender_id,
                    'message' => $msg->message,
                    'attachment_type' => $msg->attachment_type,
                    'attachment_data' => $msg->attachment_data,
                    'created_at' => $msg->created_at->diffForHumans(),
                    'is_mine' => $msg->sender_id === Auth::id(),
                    'sender_name' => $msg->sender->name,
                ];
            })
        ]);
    }

    // Send a new message
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string|max:1000',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'attachment_type' => 'nullable|in:post', // 👈 Only allow 'post'
            'attachment_id' => 'required_with:attachment_type|integer',
        ]);

        $attachmentData = null;
        $attachmentType = null;

        // Handle image upload
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('chat_attachments', 'public');
            $attachmentType = 'image';
            $attachmentData = [
                'url' => asset('storage/' . $path),
                'type' => 'image',
            ];
        }

        // Handle shared post (collections removed)
        if ($request->filled('attachment_type') && $request->attachment_type === 'post') {
            $post = Post::findOrFail($request->attachment_id);
            $attachmentType = 'post';
            $attachmentData = [
                'id' => $post->id,
                'title' => $post->title,
                'image' => $post->image ? asset('storage/' . $post->image) : null,
                'url' => route('posts.show', $post),
                'type' => 'post',
            ];
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message ?? '',
            'attachment_type' => $attachmentType,
            'attachment_data' => $attachmentData,
        ]);

        $receiver = User::find($request->receiver_id);
        $receiver->notify(new MessageReceived($message));

        return response()->json([
            'status' => 'sent',
            'message' => [
                'id' => $message->id,
                'sender_id' => $message->sender_id,
                'message' => $message->message,
                'attachment_type' => $message->attachment_type,
                'attachment_data' => $message->attachment_data,
                'created_at' => $message->created_at->diffForHumans(),
                'is_mine' => true,
                'sender_name' => Auth::user()->name,
            ]
        ]);
    }
}
