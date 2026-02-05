<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contingent extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'event_id',
        'dojang_id',
        'name',
    ];

    /**
     * @return BelongsTo<Event, Contingent>
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * @return BelongsTo<Dojang, Contingent>
     */
    public function dojang(): BelongsTo
    {
        return $this->belongsTo(Dojang::class);
    }

    /**
     * @return HasMany<Registration, Contingent>
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }
}
