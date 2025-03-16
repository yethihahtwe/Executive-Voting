<?php

use App\Models\Election;
use App\Models\Position;

test('election has many positions', function () {
    // Create an election
    $election = Election::factory()->create();
    
    // Create a position for this election
    $position = Position::factory()->create([
        'election_id' => $election->id
    ]);

    // Reload the election to get fresh relationships
    $election = Election::find($election->id);

    expect($election->positions)->toHaveCount(1)
        ->and($election->positions->first()->id)->toBe($position->id);
});

test('election has many voters', function () {
    // Create an election with voters
    $election = App\Models\Election::factory()
        ->has(App\Models\Voter::factory()->count(3))
        ->create();
        
    expect($election->voters)->toHaveCount(3)
        ->and($election->voters->first()->election_id)->toBe($election->id);
});

test('election has many votes', function () {
    // Create an election
    $election = App\Models\Election::factory()->create();
    
    // Create a position for this election
    $position = App\Models\Position::factory()
        ->for($election)
        ->create();
        
    // Create voters for this election
    $voters = App\Models\Voter::factory()
        ->count(3)
        ->for($election)
        ->create();
        
    // Create a representative
    $representative = App\Models\Representative::factory()->create();
    
    // Create votes
    foreach ($voters as $voter) {
        App\Models\Vote::factory()->create([
            'voter_id' => $voter->id,
            'position_id' => $position->id,
            'representative_id' => $representative->id,
            'election_id' => $election->id
        ]);
    }
    
    expect($election->votes)->toHaveCount(3);
});
