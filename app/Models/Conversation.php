<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = [
        'user_one_id',
        'user_two_id',
    ];

    public function initiator(): BelongsTo{
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function recipient(): BelongsTo{
        return $this->belongsTo(User::class, 'user_two_id');
    }

    public function messages(): HasMany{
        return $this->hasMany(Message::class);
    }

    public function lastMessage(){
        return $this->hasOne(Message::class)->latestOfMany();
    }
}

