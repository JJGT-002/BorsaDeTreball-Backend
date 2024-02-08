<?php

namespace Database\Seeders;

use App\Models\Cycle;
use App\Models\Student;
use App\Models\StudentCycle;
use Illuminate\Database\Seeder;

class StudentCyclesSeeder extends Seeder {

    public function run(): void {
        $cycles = Cycle::all();
        $students = Student::all();

        foreach ($students as $student) {
            $randomCycle = $cycles->random();
            StudentCycle::factory()->create([
                'cycle_id' => $randomCycle->id,
                'student_id' => $student->id,
            ]);
        }
    }
}
