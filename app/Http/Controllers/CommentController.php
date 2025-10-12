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
    /**
     * Saglabā jaunu komentāru pie ieraksta
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);


        $comment = Comment::create([
            'user_id'   => Auth::id(),
            'post_id'   => $post->id,
            'content'   => $request->content,
            'parent_id' => null,
        ]);

        $this->notifyMentions($comment, $request->content);

        return back()->with('success', 'Comment added!');
    }


    public function reply(Request $request, Post $post, Comment $comment)
    {
        if ($comment->post_id !== $post->id) {
            abort(404);
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id'   => Auth::id(),
            'post_id'   => $post->id,
            'parent_id' => $comment->id,
            'content'   => $request->content,
        ]);

        return back()->with('success', 'Reply added!');
    }


    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted.');
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

    private function notifyMentions(Comment $comment, $content)
    {
        preg_match_all('/@([\w._-]+)/', $content, $matches);
        $usernames = $matches[1] ?? [];

        if (!empty($usernames)) {
            $mentionedUsers = User::whereIn('username', $usernames)->get();

            foreach ($mentionedUsers as $mentioned) {
                if ($mentioned->id !== Auth::id()) {
                    $mentioned->notify(new MentionNotification($comment, Auth::user()));
                }
            }
        }
    }
}
