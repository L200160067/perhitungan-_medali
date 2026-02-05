<?php

namespace App\Models;

use App\Enums\RegistrationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
        'participant_id',
        'contingent_id',
        'medal_id',
        'status',
    ];

    /**
     * @return BelongsTo<TournamentCategory, Registration>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(TournamentCategory::class, 'category_id');
    }

    /**
     * @return BelongsTo<Participant, Registration>
     */
    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    /**
     * @return BelongsTo<Contingent, Registration>
     */
    public function contingent(): BelongsTo
    {
        return $this->belongsTo(Contingent::class);
    }

    /**
     * @return BelongsTo<Medal, Registration>
     */
    public function medal(): BelongsTo
    {
        return $this->belongsTo(Medal::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => RegistrationStatus::class,
        ];
    }
}
