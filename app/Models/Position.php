<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    protected $fillable = [
        'title',
        'description',
        'election_id'
    ];

    // A position has its parent election
    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }

    // A position is being submitted by many votes
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
