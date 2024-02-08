<?php

namespace Database\Seeders;

use App\Models\Cycle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CyclesSeeder extends Seeder {

    public function run(): void {
        $file = Storage::disk('public')->get('cycles.json');
        $json = json_decode($file,true);
        $array = $json[2]['data'];
        foreach ($array as $cycle){
            $cyc = Cycle::create($cycle);
            $cyc->save();
        }
    }
}
