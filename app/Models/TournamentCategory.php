<?php

namespace App\Models;

use App\Enums\PoomsaeType;
use App\Enums\TournamentGender;
use App\Enums\TournamentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TournamentCategory extends Model
{
    use HasFactory;

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
            'type' => TournamentType::class,
            'gender' => TournamentGender::class,
            'poomsae_type' => PoomsaeType::class,
        ];
    }
}
