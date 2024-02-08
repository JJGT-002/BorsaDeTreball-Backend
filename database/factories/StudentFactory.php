<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory {

    public function definition(): array {
        return [
            'name' => $this->faker->name,
            'surnames' => $this->faker->lastName,
            'urlCV' => $this->faker->url,
        ];
    }
}
