<?php

namespace Database\Seeders;

use App\Models\Dojang;
use Illuminate\Database\Seeder;

class DojangSeeder extends Seeder
{
    public function run(): void
    {
        $dojangs = [
            'Satria Muda Taekwondo',
            'Garuda Academy',
            'Brawijaya Taekwondo Club',
            'Dojang Kartika',
            'Siliwangi Taekwondo Center',
        ];

        foreach ($dojangs as $name) {
            Dojang::factory()->create(['name' => $name]);
        }
    }
}
