<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class sendMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $receiverId;
    public $convId;

    public function __construct($receiverId, $convId)
    {
        $this->receiverId = $receiverId;
        $this->convId = $convId;
        \Log::info("Evento sendMessage criado para user {$receiverId}");
    }

    public function broadcastWith()
    {
        return [
            'convId'=>$this->convId
        ];
    }

    public function broadcastOn(): array
    {
        \Log::info("Evento broadcastando em: chat.{$this->receiverId}");
        return [
            new PrivateChannel('chat.'.$this->receiverId),
        ];
    }
}
