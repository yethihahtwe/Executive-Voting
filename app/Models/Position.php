<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'election_id',
        'is_active',
        'is_completed',
        'elected_representative_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_completed' => 'boolean'
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

    // A position has its own elected representative
    public function electedRepresentative(): BelongsTo
    {
        return $this->belongsTo(Representative::class);
    }
}
