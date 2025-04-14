<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Conversation;

class ConversationsSeed extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        $pairs = [
            [$users[0]->id, $users[1]->id],
            [$users[1]->id, $users[2]->id],
            [$users[2]->id, $users[0]->id],
        ];

        foreach ($pairs as [$a, $b]) {
            Conversation::create([
                'user_one_id' => $a,
                'user_two_id' => $b,
            ]);
        }
    }
}
