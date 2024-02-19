<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder {

    public function run() {
        User::factory()->count(98)->create([
            'isActivated' => 1
        ]);
        User::create([
            'email' => 'primo@gmail.com',
            'password' => bcrypt('1234'),
            'address' => 'Batoi',
            'accept' => 1,
            'role' => 'responsible',
            'isActivated' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'email' => 'jorub@gmail.com',
            'password' => bcrypt('1234'),
            'address' => 'Batoi',
            'accept' => 1,
            'role' => 'admin',
            'isActivated' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
