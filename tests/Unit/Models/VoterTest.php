<?php

test('voter can be verified with correct ID', function () {
    $voter = App\Models\Voter::factory()->create(['voter_id' => '12345']);

    expect($voter->verifyId('12345'))->toBeTrue()
        ->and($voter->verifyId('wrong'))->toBeFalse();
});

test('voter belongs to an organization', function () {
    $organization = App\Models\Organization::factory()->create();
    $voter = App\Models\Voter::factory()
        ->for($organization)
        ->create();
        
    expect($voter->organization->id)->toBe($organization->id);
});

test('voter belongs to an election', function () {
    $election = App\Models\Election::factory()->create();
    $voter = App\Models\Voter::factory()
        ->for($election)
        ->create();
        
    expect($voter->election->id)->toBe($election->id);
});

test('voter has many votes', function () {
    $election = App\Models\Election::factory()->create();
    $voter = App\Models\Voter::factory()
        ->for($election)
        ->create();
        
    // Create positions in this election
    $positions = App\Models\Position::factory()
        ->count(3)
        ->for($election)
        ->create();
        
    // Create a representative
    $representative = App\Models\Representative::factory()->create();
    
    // Create votes for each position
    foreach ($positions as $position) {
        App\Models\Vote::factory()->create([
            'voter_id' => $voter->id,
            'position_id' => $position->id,
            'representative_id' => $representative->id,
            'election_id' => $election->id
        ]);
    }
    
    expect($voter->votes)->toHaveCount(3);
});

test('voter has sessions', function () {
    $voter = App\Models\Voter::factory()->create();
    
    // Create sessions for this voter
    $sessions = App\Models\VoterSession::factory()
        ->count(2)
        ->for($voter)
        ->create();
        
    expect($voter->sessions)->toHaveCount(2);
});
