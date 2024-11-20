<?php

namespace Database\Seeders;

use App\Models\Zone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZoneStateCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //        
        Zone::create(['zone_name' => 'North Zone']);
        Zone::create(['zone_name' => 'East Zone']);
        Zone::create(['zone_name' => 'West Zone']);
        Zone::create(['zone_name' => 'South Zone']);
        Zone::create(['zone_name' => 'Central Zone']);
        Zone::create(['zone_name' => 'North East Zone']);
        Zone::create(['zone_name' => 'None']);

    }
}
