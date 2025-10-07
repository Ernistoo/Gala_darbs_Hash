<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MentionNotification extends Notification
{
    use Queueable;

    public $comment;
    public $sender;

    public function __construct(Comment $comment, $sender)
    {
        $this->comment = $comment;
        $this->sender = $sender;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "{$this->sender->name} mentioned you in a comment",
            'comment_id' => $this->comment->id,
            'post_id' => $this->comment->post_id,
            'url' => route('posts.show', $this->comment->post_id) . "#comment-{$this->comment->id}",
        ];
    }
}
