<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Message;
use App\Models\Conversation;

class MessagesSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Conversation::all() as $conversation) {
            $senderIds = [
                $conversation->user_one_id,
                $conversation->user_two_id,
            ];

            for ($i = 0; $i < 10; $i++) {
                Message::create([
                    'conversation_id' => $conversation->id,
                    'sender_id' => $senderIds[$i % 2],
                    'body' => fake()->sentence(),
                ]);
            }
        }
    }
}
