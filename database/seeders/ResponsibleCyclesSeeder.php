<?php

namespace Database\Seeders;

use App\Models\Cycle;
use App\Models\ResponsibleCycle;
use App\Models\User;
use Illuminate\Database\Seeder;

class ResponsibleCyclesSeeder extends Seeder
{
    public function run(): void
    {
        $allCycles = Cycle::all();
        $allResponsibles = User::where('role', 'responsible')->get();

        if ($allCycles->isEmpty() || $allResponsibles->isEmpty()) {
            $this->command->warn('No hay ciclos o responsables, no se pueden asignar responsables a ciclos.');
            return;
        }

        foreach ($allCycles as $cycle) {
            $responsible = $allResponsibles->random();

            if (!$cycle->responsibles->isEmpty()) {
                $this->command->warn("El ciclo {$cycle->id} ya tiene un responsable asignado.");
                continue;
            }

            ResponsibleCycle::factory()->create([
                'responsible_id' => $responsible->id,
                'cycle_id' => $cycle->id,
            ]);
        }

        $this->command->info('Se han asignado responsables a todos los ciclos.');
    }
}
