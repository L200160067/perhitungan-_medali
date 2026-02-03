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
