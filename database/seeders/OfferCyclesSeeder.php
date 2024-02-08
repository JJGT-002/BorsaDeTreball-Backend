<?php

namespace Database\Seeders;

use App\Models\Cycle;
use App\Models\JobOffer;
use App\Models\OfferCycle;
use Illuminate\Database\Seeder;

class OfferCyclesSeeder extends Seeder
{
    public function run(): void {
        $allCyclesIds = Cycle::pluck('id');
        $allJobOffersIds = JobOffer::pluck('id');

        foreach ($allJobOffersIds as $jobOfferId) {
            $number = rand(1,4);
            $cyclesIds = $allCyclesIds->shuffle()->take($number);
            foreach ($cyclesIds as $cycleId) {
                OfferCycle::factory()->create([
                    'job_offer_id' => $jobOfferId,
                    'cycle_id' => $cycleId,
                ]);
            }
        }
    }
}
