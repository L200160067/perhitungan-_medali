<?php

namespace App\Enums;

enum CategoryType: string
{
    case Festival = 'festival';
    case Prestasi = 'prestasi';

    public function label(): string
    {
        return match ($this) {
            self::Festival => 'Festival',
            self::Prestasi => 'Prestasi',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Festival => 'bg-green-100 text-green-800 border border-green-200',
            self::Prestasi => 'bg-purple-100 text-purple-800 border border-purple-200',
        };
    }
}
