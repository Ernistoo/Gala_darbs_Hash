<?php

namespace App\Models;

use App\Events\MessageSent;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'attachment_type',
        'attachment_data',
        'is_read'
    ];

    protected $casts = [
        'attachment_data' => 'array',
        'is_read' => 'boolean'
    ];

    
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
