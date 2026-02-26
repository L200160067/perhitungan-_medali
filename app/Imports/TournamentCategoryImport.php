<?php

namespace App\Imports;

use App\Enums\CategoryType;
use App\Enums\TournamentGender;
use App\Enums\TournamentType;
use App\Models\Event;
use App\Models\TournamentCategory;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;

class TournamentCategoryImport implements OnEachRow, SkipsEmptyRows, WithChunkReading, WithHeadingRow, WithMapping, WithValidation
{
    /**
     * @param  mixed  $row
     */
    public function map($row): array
    {
        // Trim all string values in the row
        return array_map(function ($value) {
            return is_string($value) ? trim($value) : $value;
        }, $row);
    }

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row = $row->toArray();

        // Ensure keys are present before checking (Mapping handles raw rows, but onRow gets a Row object)
        // Row object -> toArray() returns the mapped array? Yes.

        if (empty($row['nama_kategori']) || empty($row['nama_pertandingan'])) {
            return;
        }

        // Find Event (Case-insensitive search for robustness)
        $event = Event::where('name', $row['nama_pertandingan'])->first();

        // If exact match fails, try case-insensitive LIKE (for SQLite/Postgres safety if needed)
        if (! $event) {
            $event = Event::where('name', 'LIKE', $row['nama_pertandingan'])->first();
        }

        if (! $event) {
            // Skip if event not found
            return;
        }

        // Map Enums
        $type = $this->mapCompetitionType($row['jenis'] ?? '');
        $categoryType = $this->mapCategoryType($row['tipe'] ?? '');
        $gender = $this->mapGender($row['jenis_kelamin'] ?? '');

        TournamentCategory::updateOrCreate(
            [
                'event_id' => $event->id,
                'name' => $row['nama_kategori'],
                'gender' => $gender,
            ],
            [
                'type' => $type,
                'category_type' => $categoryType,
                'min_weight' => $row['berat_min'] ?? 0,
                'max_weight' => $row['berat_max'] ?? 0,
                'min_age' => $row['usia_min'] ?? 0,
                'max_age' => $row['usia_max'] ?? 0,
                'age_reference_date' => $event->start_date ?? now(), // Default to event start date or now
                'price' => $row['harga'] ?? 0,
                'description' => $row['deskripsi'] ?? null,
            ]
        );
    }

    private function mapCompetitionType($value)
    {
        $value = strtolower($value);
        if (str_contains($value, 'poomsae')) {
            return TournamentType::Poomsae;
        }

        return TournamentType::Kyourugi;
    }

    private function mapCategoryType($value)
    {
        $value = strtolower($value);
        if (str_contains($value, 'festival')) {
            return CategoryType::Festival;
        }

        return CategoryType::Prestasi;
    }

    private function mapGender($value)
    {
        $value = strtolower($value);
        if ($value === 'p' || $value === 'f' || $value === 'female' || $value === 'perempuan') {
            return TournamentGender::Female;
        }

        return TournamentGender::Male;
    }

    public function rules(): array
    {
        return [
            'nama_pertandingan' => 'required|string|exists:events,name',
            'nama_kategori' => 'required|string',
            'jenis' => 'required|string', // Kyourugi/Poomsae
            'tipe' => 'required|string', // Prestasi/Festival
            'jenis_kelamin' => 'required|string', // L/P
        ];
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
