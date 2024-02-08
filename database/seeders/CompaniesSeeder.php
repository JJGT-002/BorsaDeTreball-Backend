<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder {

    public function run(): void {
        $users = User::where('role', 'company')->get();

        foreach ($users as $user) {
            Company::factory()->create([
                'id' => $user->id,
            ]);
        }
    }
}
