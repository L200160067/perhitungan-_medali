<?php

namespace App\Enums;

enum RegistrationStatus: string
{
    case Registered = 'registered';
    case PassedWeighIn = 'passed_weigh_in';
    case FailedWeighIn = 'failed_weigh_in';
    case Competed = 'competed';
    case Dns = 'dns';
    case Dq = 'dq';

    public function label(): string
    {
        return match ($this) {
            self::Registered => 'Terdaftar',
            self::PassedWeighIn => 'Lulus Timbang',
            self::FailedWeighIn => 'Gagal Timbang',
            self::Competed => 'Bertanding',
            self::Dns => 'DNS',
            self::Dq => 'Diskualifikasi',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Registered => 'bg-gray-100 text-gray-800',
            self::PassedWeighIn => 'bg-blue-100 text-blue-800',
            self::FailedWeighIn => 'bg-orange-100 text-orange-800',
            self::Competed => 'bg-green-100 text-green-800',
            self::Dns => 'bg-slate-100 text-slate-800',
            self::Dq => 'bg-red-100 text-red-800',
        };
    }
}
