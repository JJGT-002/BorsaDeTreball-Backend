<?php

namespace Database\Seeders;

use App\Models\Cycle;
use App\Models\ResponsibleCycle;
use App\Models\User;
use Illuminate\Database\Seeder;

class ResponsibleCyclesSeeder extends Seeder {

    public function run(): void {
        $allCyclesIds = Cycle::pluck('id');
        $allResponsiblesIds = User::where('role', 'responsible')->pluck('id');

        foreach ($allResponsiblesIds as $responsableId) {
            $number = rand(1,4);
            $cyclesIds = $allCyclesIds->shuffle()->take($number);
            foreach ($cyclesIds as $cycleId) {
                ResponsibleCycle::factory()->create([
                    'responsible_id' => $responsableId,
                    'cycle_id' => $cycleId,
                ]);
            }
        }
    }
}
