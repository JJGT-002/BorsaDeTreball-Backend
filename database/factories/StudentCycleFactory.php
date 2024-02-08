<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentCycleFactory extends Factory {

    public function definition(): array {
        return [
            'endDate' => $this->faker->numberBetween(2000, 2030)
        ];
    }
}
