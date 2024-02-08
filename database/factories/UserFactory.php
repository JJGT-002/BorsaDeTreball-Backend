<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory {

    protected static ?string $password;

    public function definition(): array {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('1234'),
            'address' => $this->faker->address,
            'role' => $this->faker->randomElement(['student', 'company']),
            'remember_token' => Str::random(10),
        ];
    }
}
