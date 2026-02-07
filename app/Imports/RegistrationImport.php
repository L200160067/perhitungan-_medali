<?php

namespace App\Imports;

use App\Models\Contingent;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Registration;
use App\Models\TournamentCategory;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

// NOTE: This import uses English header names (unlike other imports that use Indonesian)
class RegistrationImport implements OnEachRow, WithHeadingRow, WithChunkReading, WithValidation, SkipsEmptyRows
{
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        // 1. Find Event
        $event = Event::where('name', $row['event_name'])->first();

        // 2. Find Category (Must exist)
        $category = TournamentCategory::where('name', $row['category_name'])
            ->where('event_id', $event?->id)
            ->first();

        if (!$event || !$category) {
            return;
        }

        // 3. Find or Create Dojang (Required for Participant & Contingent)
        $dojang = \App\Models\Dojang::firstOrCreate(['name' => $row['dojang_name']]);

        // 4. Find or Create Contingent
        $contingent = Contingent::firstOrCreate(
            [
                'name' => $row['contingent_name'],
                'event_id' => $event->id,
                'dojang_id' => $dojang->id,
            ]
        );

        // 5. Find or Create Participant
        $participant = Participant::firstOrCreate(
            [
                'name' => $row['participant_name'],
                'dojang_id' => $dojang->id,
            ],
            [
                'gender' => \App\Enums\ParticipantGender::Male, 
            ]
        );

        // 6. Create Registration (Avoid duplicates)
        Registration::firstOrCreate([
            'category_id' => $category->id,
            'participant_id' => $participant->id,
            'contingent_id' => $contingent->id,
            'medal_id' => null,
        ]);
    }

    public function rules(): array
    {
        return [
            'event_name' => ['required', 'exists:events,name'],
            'category_name' => ['required', 'exists:tournament_categories,name'],
            'participant_name' => ['required', 'string'],
            'contingent_name' => ['required', 'string'],
            'dojang_name' => ['required', 'string'],
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
