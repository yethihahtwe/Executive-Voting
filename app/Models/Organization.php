<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'abbreviation'
    ];

    // Representatives from each organization
    public function representatives():HasMany
    {
        return $this->hasMany(Representative::class);
    }

    // Voters from each organization
    public function voters(): HasMany
    {
        return $this->hasMany(Voter::class);
    }
}
