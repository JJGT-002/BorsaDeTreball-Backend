<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\StudentCycle;
use App\Models\User;
use Database\Factories\StudentCycleFactory;
use Illuminate\Database\Seeder;

class StudentsSeeder extends Seeder {

    public function run(): void {
        $users = User::where('role', 'student')->get();

        foreach ($users as $user) {
            Student::factory()->create([
                'id' => $user->id,
            ]);
        }
    }
}
