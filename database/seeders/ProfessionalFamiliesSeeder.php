<?php

namespace Database\Seeders;

use App\Models\ProfessionalFamily;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProfessionalFamiliesSeeder extends Seeder {

    public function run(): void {
        $file = Storage::disk('public')->get('families.json');
        $json = json_decode($file,true);
        $array = $json[2]['data'];
        foreach ($array as $family){
            $fam = ProfessionalFamily::create($family);
            $fam->save();
        }
    }
}
