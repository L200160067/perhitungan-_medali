<?php

namespace App\Imports;

use App\Models\Contingent;
use App\Models\Dojang;
use App\Models\Event;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use Maatwebsite\Excel\Concerns\WithMapping;

class ContingentImport implements OnEachRow, WithValidation, WithHeadingRow, WithChunkReading, SkipsEmptyRows, WithMapping
{
    /**
    * @param mixed $row
    *
    * @return array
    */
    public function map($row): array
    {
        return array_map(function ($value) {
            return is_string($value) ? trim($value) : $value;
        }, $row);
    }

    /**
    * @param Row $row
    */
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        if (empty($row['nama_kontingen']) || empty($row['nama_pertandingan']) || empty($row['nama_dojang'])) {
            return;
        }

        // Find Event
        $event = Event::where('name', $row['nama_pertandingan'])->first();
        if (!$event) {
             $event = Event::where('name', 'LIKE', $row['nama_pertandingan'])->first();
        }
        
        if (!$event) {
            return; 
        }

        // Find or Create Dojang
        $dojang = Dojang::firstOrCreate(['name' => $row['nama_dojang']]);

        Contingent::firstOrCreate(
            [
                'name' => $row['nama_kontingen'],
                'event_id' => $event->id,
                'dojang_id' => $dojang->id,
            ]
        );
    }

    public function rules(): array
    {
        return [
            'nama_kontingen' => 'required|string',
            'nama_pertandingan' => 'required|string|exists:events,name',
            'nama_dojang' => 'required|string',
        ];
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
