<?php

namespace App\Imports;

use App\Models\Contingent;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Registration;
use App\Models\TournamentCategory;
use App\Enums\ParticipantGender;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class RegistrationImport implements OnEachRow, WithHeadingRow, WithChunkReading, WithValidation, SkipsEmptyRows
{
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        // 1. Find Event
        $event = Event::where('name', $row['nama_pertandingan'])->first();

        // 2. Find Category (Must exist)
        $category = TournamentCategory::where('name', $row['nama_kategori'])
            ->where('event_id', $event?->id)
            ->first();

        if (!$event || !$category) {
            return;
        }

        // 3. Find or Create Dojang (Required for Participant & Contingent)
        $dojang = \App\Models\Dojang::firstOrCreate(['name' => $row['nama_dojang']]);

        // 4. Find or Create Contingent
        $contingent = Contingent::firstOrCreate(
            [
                'name' => $row['nama_kontingen'],
                'event_id' => $event->id,
                'dojang_id' => $dojang->id,
            ]
        );

        // 5. Gender Mapping
        $gender = $this->mapGender($row['jenis_kelamin'] ?? '');

        // 6. Find or Create Participant
        $participant = Participant::firstOrCreate(
            [
                'name' => $row['nama_peserta'],
                'dojang_id' => $dojang->id,
            ],
            [
                'gender' => $gender, 
                'birth_date' => now()->subYears(10), // Default to 10 years old if missing
            ]
        );

        // 7. Create Registration (Avoid duplicates)
        Registration::firstOrCreate([
            'category_id' => $category->id,
            'participant_id' => $participant->id,
            'contingent_id' => $contingent->id,
            'medal_id' => null,
        ]);
    }

    private function mapGender($value)
    {
        $value = strtolower($value);
        if ($value === 'p' || $value === 'f' || $value === 'female' || $value === 'perempuan') return ParticipantGender::Female;
        return ParticipantGender::Male;
    }

    public function rules(): array
    {
        return [
            'nama_pertandingan' => ['required', 'exists:events,name'],
            'nama_kategori' => ['required', 'exists:tournament_categories,name'],
            'nama_peserta' => ['required', 'string'],
            'nama_kontingen' => ['required', 'string'],
            'nama_dojang' => ['required', 'string'],
            'jenis_kelamin' => ['nullable', 'string'],
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
