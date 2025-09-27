<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create 10 users
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "User{$i}",
                'email' => "user{$i}@example.com",
                'password' => Hash::make('password123'),
            ]);
        }
    }
}
