<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use HasFactory, Notifiable;

    protected $fillable = [
        'user_name',
        'email',
        'password',
        'online'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sentMessages(){
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function conversationsStarted(){
        return $this->hasMany(Conversation::class, 'initiator_id');
    }

    public function conversationsReceived(){
        return $this->hasMany(Conversation::class, 'recipient_id');
    }

    public function allConversations(){
        return $this->conversationsStarted->merge($this->conversationsReceived);
    }

}
