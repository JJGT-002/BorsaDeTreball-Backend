<?php

namespace Database\Factories;

use App\Models\Cycle;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory {

    public function definition(): array {
        //$cycleIds = Cycle::pluck('id')->toArray();
        //$randomCycleIds = $this->faker->randomElements($cycleIds, $this->faker->numberBetween(0, 5));
        return [
            'name' => $this->faker->name,
            'surnames' => $this->faker->lastName,
            'urlCV' => $this->faker->url,
            //'cycle_id' => count($randomCycleIds) > 0 ? $this->faker->randomElement($randomCycleIds) : null,
        ];
    }
}
