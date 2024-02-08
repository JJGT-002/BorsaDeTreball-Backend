<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JobOfferFactory extends Factory {

    public function definition(): array {
        return [
            'observations' => $this->faker->sentence,
            'description' => $this->faker->text,
            'contractDuration' => $this->faker->randomElement(['3 months', '6 months', '1 year']),
            'registrationMethod' => $this->faker->randomElement(['email', 'atTheMoment']),
        ];
    }
}
