<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MessageReceived extends Notification
{
    use Queueable;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "{$this->message->sender->name} sent you a message",
            'sender_id' => $this->message->sender_id,
            'url' => route('friends.index') . '?chat=' . $this->message->sender_id,
            'preview' => $this->message->message,
        ];
    }
}
