<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medal extends Model
{
    use HasFactory;

    public const NAMES = [
        'gold',
        'silver',
        'bronze',
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'rank',
    ];

    /**
     * @return HasMany<Registration, Medal>
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function color(): string
    {
        return match (strtolower($this->name)) {
            'gold' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
            'silver' => 'bg-gray-100 text-gray-800 border border-gray-200',
            'bronze' => 'bg-orange-100 text-orange-800 border border-orange-200',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function label(): string
    {
        return match (strtolower($this->name)) {
            'gold' => 'Emas',
            'silver' => 'Perak',
            'bronze' => 'Perunggu',
            default => $this->name,
        };
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rank' => 'integer',
        ];
    }
}
