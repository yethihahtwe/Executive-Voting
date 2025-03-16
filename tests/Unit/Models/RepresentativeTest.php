<?php

test('representative belongs to an organization', function () {
    $organization = App\Models\Organization::factory()->create();
    $representative = App\Models\Representative::factory()
        ->for($organization)
        ->create();
        
    expect($representative->organization->id)->toBe($organization->id);
});

test('representative has many votes', function () {
    $election = App\Models\Election::factory()->create();
    $position = App\Models\Position::factory()
        ->for($election)
        ->create();
        
    $representative = App\Models\Representative::factory()->create();
    
    // Create voters
    $voters = App\Models\Voter::factory()
        ->count(3)
        ->for($election)
        ->create();
    
    // Create votes for each voter
    foreach ($voters as $voter) {
        App\Models\Vote::factory()->create([
            'voter_id' => $voter->id,
            'position_id' => $position->id,
            'representative_id' => $representative->id,
            'election_id' => $election->id
        ]);
    }
    
    expect($representative->votes)->toHaveCount(3);
});
