<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory {

    public function definition(): array
    {
        $sociedadType = $this->faker->randomElement(['A', 'B']);
        $cifNumber = str_pad($this->faker->randomNumber(7), 7, '0', STR_PAD_LEFT);
        $lastCharacter = $this->faker->randomElement(['A', 'B']);
        return [
            'name' => $this->faker->company,
            'cif' => $sociedadType . $cifNumber . $lastCharacter,
            'contactName' => $this->faker->name,
            'companyWeb' => $this->faker->url,
        ];
    }
}
