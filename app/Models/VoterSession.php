<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VoterSession extends Model
{
    use HasFactory;
    protected $fillable = [
        'voter_id',
        'session_id',
        'device_info',
        'ip_address',
        'last_activity',
        'is_active',
    ];

    protected $casts = [
        'last_activity' => 'datetime',
        'is_active' => 'boolean',
    ];

    // A voter session belongs to a voter
    public function voter(): BelongsTo
    {
        return $this->belongsTo(Voter::class);
    }
}
