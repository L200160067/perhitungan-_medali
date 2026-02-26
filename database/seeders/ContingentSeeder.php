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
        $events = Event::all();
        if ($events->isEmpty()) {
            $events = Event::factory()->count(1)->create();
        }

        $dojangs = Dojang::all();
        if ($dojangs->isEmpty()) {
            $dojangs = Dojang::factory()->count(5)->create();
        }

        foreach ($events as $event) {
            // Assign some dojangs as contingents for each event
            $selectedDojangs = $dojangs->random(rand(2, 5));
            foreach ($selectedDojangs as $dojang) {
                Contingent::factory()->create([
                    'event_id' => $event->id,
                    'dojang_id' => $dojang->id,
                    'name' => $dojang->name.' - '.$event->name,
                ]);
            }
        }
    }
}
