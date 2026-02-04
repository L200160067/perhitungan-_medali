<?php

namespace Database\Seeders;

use App\Models\Medal;
use Illuminate\Database\Seeder;

class MedalSeeder extends Seeder
{
    public function run(): void
    {
        Medal::updateOrCreate(['name' => 'gold'], ['rank' => 1]);
        Medal::updateOrCreate(['name' => 'silver'], ['rank' => 2]);
        Medal::updateOrCreate(['name' => 'bronze'], ['rank' => 3]);
    }
}
