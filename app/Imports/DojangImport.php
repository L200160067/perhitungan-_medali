<?php

namespace App\Imports;

use App\Models\Dojang;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMapping;

class DojangImport implements OnEachRow, WithValidation, WithHeadingRow, WithChunkReading, SkipsEmptyRows, WithMapping
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

        // Don't create if name is missing
        if (empty($row['nama'])) {
            return;
        }

        // Avoid duplicates by using firstOrCreate or just checking
        Dojang::firstOrCreate(
            ['name' => $row['nama']],
            ['name' => $row['nama']]
        );
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
        ];
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
