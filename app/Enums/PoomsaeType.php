<?php

namespace App\Enums;

enum PoomsaeType: string
{
    case Individual = 'individual';
    case Pair = 'pair';
    case Team = 'team';

    public function label(): string
    {
        return match ($this) {
            self::Individual => 'Perorangan',
            self::Pair => 'Berpasangan',
            self::Team => 'Beregu',
        };
    }
}
