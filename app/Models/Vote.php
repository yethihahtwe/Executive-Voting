<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    protected $fillable = [
        'voter_id',
        'representative_id',
        'position_id',
        'election_id'
    ];

    // A vote has its own voter
    public function voter(): BelongsTo
    {
        return $this->belongsTo(Voter::class);
    }

    // A vote is for a representative
    public function representative(): BelongsTo
    {
        return $this->belongsTo(Representative::class);
    }

    // A vote is for a particular position
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    // A vote is related to a particular election
    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }
}
