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
        do {
            $numbers = str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT);
            $tokenResponsible = $numbers . '|' . Str::random(40);
        } while (User::where('token', $tokenResponsible)->exists());
        User::create([
            'email' => 'primo@gmail.com',
            'password' => bcrypt('1234'),
            'address' => 'Batoi',
            'accept' => 1,
            'role' => 'responsible',
            'isActivated' => 1,
            'email_verified_at' => now(),
            'token' => $tokenResponsible,
        ]);
        do {
            $numbers = str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT);
            $tokenAdmin = $numbers . '|' . Str::random(40);
        } while (User::where('token', $tokenAdmin)->exists());
        User::create([
            'email' => 'jorub@gmail.com',
            'password' => bcrypt('1234'),
            'address' => 'Batoi',
            'accept' => 1,
            'role' => 'admin',
            'isActivated' => 1,
            'email_verified_at' => now(),
            'token' => $tokenAdmin,
        ]);
    }
}
