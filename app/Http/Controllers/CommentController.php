<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\MentionNotification;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
{
    $request->validate([
        'content' => 'required|string|max:500',
    ]);

    $comment = $post->comments()->create([
        'user_id' => Auth::id(),
        'content' => $request->content,
    ]);

   
    preg_match_all('/@([\w._-]+)/', $request->content, $matches);
    $usernames = $matches[1] ?? [];

    if (!empty($usernames)) {
        $mentionedUsers = User::whereIn('username', $usernames)->get();
        foreach ($mentionedUsers as $mentioned) {
            if ($mentioned->id !== Auth::id()) { 
                $mentioned->notify(new MentionNotification($comment, Auth::user()));
            }
        }
    }

    return back();
}

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403);
        }

        $comment->delete();
        return back();
    }

    public function pin(Comment $comment)
    {
        $post = $comment->post;

        if (auth()->id() !== $post->user_id) {
            abort(403);
        }

        $post->comments()->update(['is_pinned' => false]);

        $comment->is_pinned = true;
        $comment->save();

        return back()->with('success', 'Comment pinned!');
    }
}
