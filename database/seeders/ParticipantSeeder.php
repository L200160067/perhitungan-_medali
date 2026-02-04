<?php

namespace Database\Seeders;

use App\Models\Dojang;
use App\Models\Participant;
use Illuminate\Database\Seeder;

class ParticipantSeeder extends Seeder
{
    public function run(): void
    {
        $dojangs = Dojang::query()->get();
        if ($dojangs->isEmpty()) {
            $dojangs = Dojang::factory()->count(5)->create();
        }

        foreach ($dojangs as $dojang) {
            $count = random_int(8, 20);
            $maleCount = (int) floor($count / 2);
            $femaleCount = $count - $maleCount;

            Participant::factory()
                ->count($maleCount)
                ->gender('M')
                ->ageBetween(10, 25)
                ->create(['dojang_id' => $dojang->id]);

            Participant::factory()
                ->count($femaleCount)
                ->gender('F')
                ->ageBetween(10, 25)
                ->create(['dojang_id' => $dojang->id]);
        }
    }
}
