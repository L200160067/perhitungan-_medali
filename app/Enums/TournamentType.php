<?php

namespace App\Enums;

enum TournamentType: string
{
    case Kyourugi = 'kyourugi';
    case Poomsae = 'poomsae';

    public function label(): string
    {
        return match ($this) {
            self::Kyourugi => 'Kyourugi (Tanding)',
            self::Poomsae => 'Poomsae (Jurus)',
        };
    }
}
