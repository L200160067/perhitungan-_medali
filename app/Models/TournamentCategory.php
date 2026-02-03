<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TournamentCategory extends Model
{
    use HasFactory;

    public const TYPES = [
        'kyourugi',
        'poomsae',
    ];

    public const GENDERS = [
        'M',
        'F',
        'Mixed',
    ];

    public const POOMSAE_TYPES = [
        'individual',
        'pair',
        'team',
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'event_id',
        'name',
        'type',
        'gender',
        'age_reference_date',
        'min_age',
        'max_age',
        'weight_class_name',
        'min_weight',
        'max_weight',
        'poomsae_type',
    ];

    /**
     * @return BelongsTo<Event, TournamentCategory>
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * @return HasMany<Registration, TournamentCategory>
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class, 'category_id');
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'age_reference_date' => 'date',
            'min_age' => 'integer',
            'max_age' => 'integer',
            'min_weight' => 'decimal:2',
            'max_weight' => 'decimal:2',
        ];
    }
}
