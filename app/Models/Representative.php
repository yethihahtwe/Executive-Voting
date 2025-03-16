<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Representative extends Model
{
    protected $fillable = [
        'organization_id',
        'name',
    ];

    // A representative has their parent organization
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    // A representative has many votes on them
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
