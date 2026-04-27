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
    use SerializesModels;

    public function __construct(public Message $message) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->message->receiver_id),
            new PrivateChannel('user.' . $this->message->sender_id),
        ];
    }

    public function broadcastWith()
{
    $sender = $this->message->sender;
    $avatar = userAvatar($sender->profile_photo);

    return [
        'message' => [
            'id' => $this->message->id,
            'sender_id' => $this->message->sender_id,
            'receiver_id' => $this->message->receiver_id,
            'message' => $this->message->message,
            'attachment_type' => $this->message->attachment_type,
            'attachment_data' => $this->message->attachment_data,
            'created_at' => $this->message->created_at->diffForHumans(),
            'sender' => [
                'id' => $sender->id,
                'name' => $sender->name,
                'username' => $sender->username,
                'profile_photo' => $sender->profile_photo,
                'avatar_url' => $avatar, 
            ]
        ]
    ];
}
}
