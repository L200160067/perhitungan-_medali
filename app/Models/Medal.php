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
            'gold' => 'bg-yellow-100 text-yellow-800 ring-1 ring-inset ring-yellow-300 dark:bg-yellow-400/20 dark:text-yellow-300 dark:ring-yellow-400/40',
            'silver' => 'bg-gray-100 text-gray-700 ring-1 ring-inset ring-gray-300 dark:bg-gray-400/20 dark:text-gray-300 dark:ring-gray-400/40',
            'bronze' => 'bg-orange-100 text-orange-800 ring-1 ring-inset ring-orange-300 dark:bg-orange-400/20 dark:text-orange-300 dark:ring-orange-400/40',
            default => 'bg-slate-100 text-slate-700 ring-1 ring-inset ring-slate-300 dark:bg-slate-400/20 dark:text-slate-300 dark:ring-slate-400/40',
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
