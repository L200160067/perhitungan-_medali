<?php

namespace Database\Seeders;

use App\Models\Dojang;
use Illuminate\Database\Seeder;

class DojangSeeder extends Seeder
{
    public function run(): void
    {
        Dojang::factory()->count(5)->create();
    }
}
