<?php

namespace App\Imports;

use App\Enums\TournamentGender;
use App\Models\Dojang;
use App\Models\Participant;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ParticipantImport implements OnEachRow, WithValidation, WithHeadingRow, WithChunkReading, SkipsEmptyRows
{
    /**
    * @param Row $row
    */
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        if (empty($row['nama'])) {
            return;
        }

        // Find or Create Dojang
        $dojang = null;
        if (!empty($row['dojang'])) {
            $dojang = Dojang::firstOrCreate(['name' => $row['dojang']]);
        }

        $birthDate = $this->transformDate($row['tanggal_lahir'] ?? null);
        $gender = $this->mapGender($row['jenis_kelamin'] ?? '');

        Participant::updateOrCreate(
            [
                'name' => $row['nama'],
                'dojang_id' => $dojang?->id,
                'birth_date' => $birthDate?->format('Y-m-d'),
                'gender' => $gender,
            ],
            [
                'weight' => $row['berat_badan'] ?? 0,
                'height' => $row['tinggi_badan'] ?? 0,
            ]
        );
    }

    private function transformDate($value)
    {
        if (!$value) return null;
        
        try {
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value);
            }
            return \Carbon\Carbon::parse($value);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function mapGender($value)
    {
        $value = strtolower($value);
        if ($value === 'p' || $value === 'f' || $value === 'female' || $value === 'perempuan') return TournamentGender::Female;
        return TournamentGender::Male;
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string',
            'dojang' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'tanggal_lahir' => 'required',
        ];
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
