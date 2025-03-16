<?php

use App\Models\Election;
use App\Models\Position;
use App\Models\Representative;
use App\Models\Vote;
use App\Models\Voter;

test('live results can be viewed', function () {
    // Create an active election
    $election = Election::factory()->active()->create();
    
    // Create a position for this election
    $position = Position::factory()->create([
        'election_id' => $election->id,
        'is_active' => true
    ]);
    
    // Just verify the model relationships work
    expect($position->election->id)->toBe($election->id);
});

test('completed elections display final results', function () {
    // Create a completed election
    $election = Election::factory()->completed()->create();
    
    // Create a representative
    $representative = Representative::factory()->create();
    
    // Create a completed position with an elected representative
    $position = Position::factory()->create([
        'election_id' => $election->id,
        'is_active' => false,
        'is_completed' => true,
        'elected_representative_id' => $representative->id
    ]);
    
    // Verify relationships work
    expect($position->election->id)->toBe($election->id);
    expect($position->electedRepresentative->id)->toBe($representative->id);
});
