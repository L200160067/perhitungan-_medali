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
            'gold' => 'bg-yellow-100 text-yellow-800 border border-yellow-200 dark:bg-yellow-500 dark:text-yellow-950 dark:border-yellow-500',
            'silver' => 'bg-gray-100 text-gray-800 border border-gray-200 dark:bg-gray-300 dark:text-gray-900 dark:border-gray-300',
            'bronze' => 'bg-orange-100 text-orange-800 border border-orange-200 dark:bg-orange-500 dark:text-orange-950 dark:border-orange-500',
            default => 'bg-slate-100 text-slate-800 border border-slate-200 dark:bg-slate-700 dark:text-slate-200 dark:border-slate-600',
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
