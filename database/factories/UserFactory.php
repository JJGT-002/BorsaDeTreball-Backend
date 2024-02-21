<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory {

    protected static ?string $password;

    public function definition(): array {
        do {
            $numbers = str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT);
            $token = $numbers . '|' . Str::random(40);
        } while (User::where('token', $token)->exists());
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('1234'),
            'address' => $this->faker->address,
            'accept' => 1,
            'role' => $this->faker->randomElement(['student', 'company']),
            'token' => $token,
        ];
    }
}
