<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        $users = [
            ['name' => 'Admin User', 'email' => 'admin@viajes.com', 'password' => 'password', 'role' => 'admin'],
            ['name' => 'Usuario Uno', 'email' => 'usuario1@viajes.com', 'password' => 'password', 'role' => 'user'],
            ['name' => 'Usuario Dos', 'email' => 'usuario2@viajes.com', 'password' => 'password', 'role' => 'user'],
        ];

        foreach ($users as $userData) {
            \App\Models\User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => \Illuminate\Support\Facades\Hash::make($userData['password']),
                'role' => $userData['role'],
            ]);
        }
    }
}
