<?php

namespace Database\Seeders;

use App\Models\JobOffer;
use App\Models\Student;
use App\Models\StudentEnrolledOffer;
use Illuminate\Database\Seeder;

class StudentEnrolledOffersSeeder extends Seeder {

    public function run(): void {
        $allStudentsIds = Student::pluck('id');
        $allJobOffersIds = JobOffer::pluck('id');

        foreach ($allJobOffersIds as $jobOfferId) {
            $number = rand(1,4);
            $studentsIds = $allStudentsIds->shuffle()->take($number);
            foreach ($studentsIds as $studentsId) {
                StudentEnrolledOffer::factory()->create([
                    'student_id' => $studentsId,
                    'job_offer_id' => $jobOfferId
                ]);
            }
        }
    }
}
