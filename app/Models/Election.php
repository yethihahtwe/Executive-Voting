<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Election extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'is_active',
        'completed'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'completed' => 'boolean',
    ];

    // An election event has many positions to be elected
    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }

    // An election event has many voters
    public function voters(): HasMany
    {
        return $this->hasMany(Voter::class);
    }

    // An election event has many votes
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
