<?php

use App\Models\Election;
use App\Models\Position;
use App\Models\Representative;
use App\Models\Voter;
use App\Models\Vote;

test('models can be created', function () {
    // Create an election
    $election = Election::factory()->create([
        'title' => 'Test Election',
        'is_active' => true
    ]);
    
    expect($election->title)->toBe('Test Election');
    
    // Create a position
    $position = Position::factory()->create([
        'election_id' => $election->id,
        'title' => 'President'
    ]);
    
    expect($position->title)->toBe('President');
    
    // Check the relationship
    expect($position->election->id)->toBe($election->id);
});
