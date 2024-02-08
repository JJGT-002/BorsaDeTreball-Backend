<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory {

    public function definition(): array {
        return [
            'name' => $this->faker->company,
            'cif' => $this->faker->randomNumber(8) . $this->faker->randomLetter . $this->faker->randomNumber(2),
            'contactName' => $this->faker->name,
            'companyWeb' => $this->faker->url,
        ];
    }
}
