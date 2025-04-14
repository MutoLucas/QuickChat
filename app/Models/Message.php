<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'body',
        'type',
        'media_path',
        'read_sender',
        'read_receiver'
    ];

    public function conversation(): BelongsTo{
        return $this->belongsTo(Conversation::class);
    }

    public function sender(): BelongsTo{
        return $this->belongsTo(User::class, 'sender_id');
    }
}
