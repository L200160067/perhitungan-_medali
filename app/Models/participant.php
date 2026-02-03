<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participant extends Model
{
    use HasFactory;

    public const GENDERS = [
        'M',
        'F',
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'dojang_id',
        'name',
        'gender',
        'birth_date',
    ];

    /**
     * @return BelongsTo<Dojang, Participant>
     */
    public function dojang(): BelongsTo
    {
        return $this->belongsTo(Dojang::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }
}
