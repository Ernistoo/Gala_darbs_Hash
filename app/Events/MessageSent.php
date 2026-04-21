<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        // Private channel for the receiver
        return new PrivateChannel('user.' . $this->message->receiver_id);
    }

    public function broadcastWith()
    {
        return [
            'message' => [
                'id' => $this->message->id,
                'sender_id' => $this->message->sender_id,
                'receiver_id' => $this->message->receiver_id,
                'message' => $this->message->message,
                'attachment_type' => $this->message->attachment_type,
                'attachment_data' => $this->message->attachment_data,
                'created_at' => $this->message->created_at->toDateTimeString(),
                'sender' => [
                    'id' => $this->message->sender->id,
                    'name' => $this->message->sender->name,
                    'username' => $this->message->sender->username,
                    'profile_photo' => $this->message->sender->profile_photo,
                ]
            ]
        ];
    }
}
