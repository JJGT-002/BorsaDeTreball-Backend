<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder {

    public function run() {
        User::factory()->count(200)->create([
            'isActivated' => 1
        ]);
        $users = User::all();
        foreach ($users as $user) {
            do {
                $token = $user->createToken('Personal Access Token')->plainTextToken;
            } while (User::where('token', $token)->exists());

            $user->forceFill([
                'token' => $token,
            ])->save();
        }
        for ($i = 0; $i < 5; $i++) {
            $responsible = User::create([
                'email' => 'responsible_' . $i+1 . '@gmail.com',
                'password' => bcrypt('password123'),
                'address' => 'Dirección ' . $i+1,
                'accept' => 1,
                'role' => 'responsible',
                'isActivated' => 1,
                'email_verified_at' => now(),
            ]);

            do {
                $token = $responsible->createToken('Personal Access Token')->plainTextToken;
            } while (User::where('token', $token)->exists());

            $responsible->forceFill([
                'token' => $token,
            ])->save();
        }
        $admin = User::create([
            'email' => 'jorub@gmail.com',
            'password' => bcrypt('1234'),
            'address' => 'Batoi',
            'accept' => 1,
            'role' => 'admin',
            'isActivated' => 1,
            'email_verified_at' => now(),
        ]);
        do {
            $token = $admin->createToken('Personal Access Token')->plainTextToken;
        } while (User::where('token', $token)->exists());

        $admin->forceFill([
            'token' => $token,
        ])->save();
    }
}
