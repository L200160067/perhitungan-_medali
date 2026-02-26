<?php

namespace App\Imports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class EventImport implements OnEachRow, SkipsEmptyRows, WithChunkReading, WithHeadingRow, WithValidation
{
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row = $row->toArray();

        if (empty($row['nama_pertandingan'])) {
            return;
        }

        // Handle Excel Date format if numeric, otherwise standard parse
        $startDate = $this->transformDate($row['tanggal_mulai'] ?? null);
        $endDate = $this->transformDate($row['tanggal_selesai'] ?? null);

        // Use updateOrCreate to allow updating existing events
        Event::updateOrCreate(
            ['name' => $row['nama_pertandingan']],
            [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'location' => $row['lokasi'] ?? null,
                'description' => $row['deskripsi'] ?? null,
                'is_active' => true,
            ]
        );
    }

    private function transformDate($value)
    {
        if (! $value) {
            return now();
        }

        try {
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value);
            }

            return \Carbon\Carbon::parse($value);
        } catch (\Exception $e) {
            return now();
        }
    }

    public function rules(): array
    {
        return [
            'nama_pertandingan' => 'required|string|max:255',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
        ];
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
