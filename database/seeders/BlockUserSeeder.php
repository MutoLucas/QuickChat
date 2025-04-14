<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Block;

class BlockUserSeeder extends Seeder
{

    public function run(): void
    {
        Block::create([
            'user_who_blocked_id'=>1,
            'user_blocked_id'=>5
        ]);
    }
}
