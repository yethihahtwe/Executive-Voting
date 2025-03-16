<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Voter extends Model
{
    use HasFactory;
    protected $fillable = [
        'voter_id',
        'organization_id',
        'election_id',
        'has_voted',
        'voted_at'
    ];

    protected $casts = [
        'has_voted' => 'boolean',
        'voted_at' => 'datetime',
    ];

    // A voter has their parent organization
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    // A voter belongs to an election
    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }

    // A voter can have many votes for different positions
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    // A voter is monitored if they have many voter sessions
    public function sessions(): HasMany
    {
        return $this->hasMany(VoterSession::class);
    }
    
    /**
     * Verify if the provided ID matches this voter's ID
     *
     * @param string $voterId
     * @return bool
     */
    public function verifyId(string $voterId): bool
    {
        return $this->voter_id === $voterId;
    }
}
