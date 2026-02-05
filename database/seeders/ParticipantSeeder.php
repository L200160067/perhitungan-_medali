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

        $maleNames = ['Budi Santoso', 'Agus Prayogo', 'Eko Wijaya', 'Iwan Setiawan', 'Hadi Kusuma', 'Rian Hidayat', 'Dedi Kurniawan', 'Fajar Pratama', 'Bambang Sudjatmiko', 'Taufik Hidayat'];
        $femaleNames = ['Siti Aminah', 'Dewi Lestari', 'Ani Wijaya', 'Sri Wahyuni', 'Indah Permata', 'Putri Utami', 'Rina Marlina', 'Maya Safitri', 'Lani Cahyani', 'Dian Sastro'];

        foreach ($dojangs as $dojang) {
            $countPerGender = 5;

            foreach (array_slice($maleNames, 0, $countPerGender) as $name) {
                Participant::factory()
                    ->gender('M')
                    ->ageBetween(10, 25)
                    ->create([
                        'dojang_id' => $dojang->id,
                        'name' => $name,
                    ]);
            }

            foreach (array_slice($femaleNames, 0, $countPerGender) as $name) {
                Participant::factory()
                    ->gender('F')
                    ->ageBetween(10, 25)
                    ->create([
                        'dojang_id' => $dojang->id,
                        'name' => $name,
                    ]);
            }
        }
    }
}
