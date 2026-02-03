<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    use HasFactory;

    public const STATUSES = [
        'registered',
        'passed_weigh_in',
        'failed_weigh_in',
        'competed',
        'dns',
        'dq',
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
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
}
