<?php

test('vote belongs to a voter', function () {
    $election = App\Models\Election::factory()->create();
    $position = App\Models\Position::factory()
        ->for($election)
        ->create();
        
    $voter = App\Models\Voter::factory()
        ->for($election)
        ->create();
        
    $representative = App\Models\Representative::factory()->create();
    
    $vote = App\Models\Vote::factory()->create([
        'voter_id' => $voter->id,
        'position_id' => $position->id,
        'representative_id' => $representative->id,
        'election_id' => $election->id
    ]);
    
    expect($vote->voter->id)->toBe($voter->id);
});

test('vote belongs to a representative', function () {
    $election = App\Models\Election::factory()->create();
    $position = App\Models\Position::factory()
        ->for($election)
        ->create();
        
    $voter = App\Models\Voter::factory()
        ->for($election)
        ->create();
        
    $representative = App\Models\Representative::factory()->create();
    
    $vote = App\Models\Vote::factory()->create([
        'voter_id' => $voter->id,
        'position_id' => $position->id,
        'representative_id' => $representative->id,
        'election_id' => $election->id
    ]);
    
    expect($vote->representative->id)->toBe($representative->id);
});

test('vote belongs to a position', function () {
    $election = App\Models\Election::factory()->create();
    $position = App\Models\Position::factory()
        ->for($election)
        ->create();
        
    $voter = App\Models\Voter::factory()
        ->for($election)
        ->create();
        
    $representative = App\Models\Representative::factory()->create();
    
    $vote = App\Models\Vote::factory()->create([
        'voter_id' => $voter->id,
        'position_id' => $position->id,
        'representative_id' => $representative->id,
        'election_id' => $election->id
    ]);
    
    expect($vote->position->id)->toBe($position->id);
});

test('vote belongs to an election', function () {
    $election = App\Models\Election::factory()->create();
    $position = App\Models\Position::factory()
        ->for($election)
        ->create();
        
    $voter = App\Models\Voter::factory()
        ->for($election)
        ->create();
        
    $representative = App\Models\Representative::factory()->create();
    
    $vote = App\Models\Vote::factory()->create([
        'voter_id' => $voter->id,
        'position_id' => $position->id,
        'representative_id' => $representative->id,
        'election_id' => $election->id
    ]);
    
    expect($vote->election->id)->toBe($election->id);
});
