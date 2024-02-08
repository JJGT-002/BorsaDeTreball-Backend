<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    public function run(): void {
        $this->call([
            ProfessionalFamiliesSeeder::class,
            CyclesSeeder::class,
            UsersSeeder::class,
            StudentsSeeder::class,
            CompaniesSeeder::class,
            JobOfferSeeder::class,
            StudentCyclesSeeder::class,
            StudentEnrolledOffersSeeder::class,
            OfferCyclesSeeder::class,
        ]);
    }
}
