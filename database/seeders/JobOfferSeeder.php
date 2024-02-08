<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\JobOffer;
use Illuminate\Database\Seeder;

class JobOfferSeeder extends Seeder {

    public function run(): void {
        $companies = Company::all();

        foreach ($companies as $company) {
            JobOffer::factory()->create([
                'company_id' => $company->id,
                'contact' => $company->contactName,
            ]);
        }
    }
}
