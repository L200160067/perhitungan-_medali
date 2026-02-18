<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'gold_point',
        'silver_point',
        'bronze_point',
        'count_festival_medals',
        'is_locked',
    ];

    /**
     * @return HasMany<Contingent, Event>
     */
    public function contingents(): HasMany
    {
        return $this->hasMany(Contingent::class);
    }

    /**
     * @return HasMany<TournamentCategory, Event>
     */
    public function tournamentCategories(): HasMany
    {
        return $this->hasMany(TournamentCategory::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'gold_point' => 'integer',
            'silver_point' => 'integer',
            'bronze_point' => 'integer',
            'count_festival_medals' => 'boolean',
            'is_locked' => 'boolean',
        ];
    }
}
