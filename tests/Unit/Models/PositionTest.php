<?php

test('position belongs to an election', function () {
    $election = App\Models\Election::factory()->create();
    $position = App\Models\Position::factory()
        ->for($election)
        ->create();
        
    expect($position->election->id)->toBe($election->id);
});

test('position has many votes', function () {
    $election = App\Models\Election::factory()->create();
    $position = App\Models\Position::factory()
        ->for($election)
        ->create();
        
    // Create voters
    $voters = App\Models\Voter::factory()
        ->count(3)
        ->for($election)
        ->create();
        
    // Create a representative
    $representative = App\Models\Representative::factory()->create();
    
    // Create votes for each voter
    foreach ($voters as $voter) {
        App\Models\Vote::factory()->create([
            'voter_id' => $voter->id,
            'position_id' => $position->id,
            'representative_id' => $representative->id,
            'election_id' => $election->id
        ]);
    }
    
    expect($position->votes)->toHaveCount(3);
});

test('position can have an elected representative', function () {
    $election = App\Models\Election::factory()->create();
    $representative = App\Models\Representative::factory()->create();
    
    $position = App\Models\Position::factory()
        ->for($election)
        ->create([
            'elected_representative_id' => $representative->id
        ]);
        
    expect($position->electedRepresentative->id)->toBe($representative->id);
});
