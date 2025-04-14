<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class USerSeeder extends Seeder
{

    public function run(): void
    {
        User::create([
            'user_name'=>'MutoLucas',
            'email'=>'lucasfbr123@gmail.com',
            'password'=>bcrypt('Lucas123')
        ]);

        User::create([
            'user_name'=>'Rafael',
            'email'=>'rafael@gmail.com',
            'password'=>bcrypt('Rafael123')
        ]);

        User::create([
            'user_name'=>'Elliton',
            'email'=>'elliton@gmail.com',
            'password'=>bcrypt('Elliton123')
        ]);

        User::create([
            'user_name'=>'Gago',
            'email'=>'gago@gmail.com',
            'password'=>bcrypt('Gago123')
        ]);

        User::create([
            'user_name' => 'João Silva',
            'email' => 'joao@example.com',
            'password' => bcrypt('Joao123'),
        ]);

        User::create([
            'user_name' => 'Maria Souza',
            'email' => 'maria@example.com',
            'password' => bcrypt('Maria123'),
        ]);

        User::create([
            'user_name' => 'Carlos Lima',
            'email' => 'carlos@example.com',
            'password' => bcrypt('Carlos123'),
        ]);
    }
}
