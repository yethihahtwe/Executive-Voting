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
        'election_id',
        'is_active',
        'is_completed',
        'elected_representative_id',
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


//            $table->string('title');
 //           $table->string('description')->nullable();
//            $table->foreignId('election_id')->constrained('elections')->cascadeOnDelete();
//            $table->boolean('is_active')->default(false);
//            $table->boolean('is_completed')->default(false);
//            $table->foreignId('elected_representative_id')->nullable()->constrained('representatives');
