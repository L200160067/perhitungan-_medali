<?php

namespace Database\Seeders;

use App\Models\Contingent;
use App\Models\Dojang;
use App\Models\Event;
use Illuminate\Database\Seeder;

class ContingentSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::query()->first() ?? Event::factory()->create();

        $dojangs = Dojang::query()->take(5)->get();
        if ($dojangs->isEmpty()) {
            $dojangs = Dojang::factory()->count(5)->create();
        }

        foreach ($dojangs as $dojang) {
            Contingent::factory()->create([
                'event_id' => $event->id,
                'dojang_id' => $dojang->id,
                'name' => $dojang->name . ' Contingent',
            ]);
        }
    }
}
