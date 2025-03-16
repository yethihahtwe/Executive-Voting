<?php

use App\Models\User;
use App\Models\Election;
use App\Models\Position;
use App\Models\Organization;

test('models can be created and queried', function () {
    // Test that we can create and query user models
    $user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com'
    ]);
    
    $this->assertDatabaseHas('users', [
        'name' => 'Test User',
        'email' => 'test@example.com'
    ]);
    
    // Test that we can create and query election models
    $election = Election::factory()->create([
        'title' => 'Test Election'
    ]);
    
    $this->assertDatabaseHas('elections', [
        'title' => 'Test Election'
    ]);
    
    // Test that we can create and query with relationships
    $position = Position::factory()->create([
        'title' => 'Test Position',
        'election_id' => $election->id
    ]);
    
    $this->assertDatabaseHas('positions', [
        'title' => 'Test Position',
        'election_id' => $election->id
    ]);
});

test('model relationships work', function () {
    // Create an organization
    $organization = Organization::factory()->create([
        'name' => 'Test Organization'
    ]);
    
    // Create an election
    $election = Election::factory()->create([
        'title' => 'Test Election'
    ]);
    
    // Create a position
    $position = Position::factory()->create([
        'title' => 'Test Position',
        'election_id' => $election->id
    ]);
    
    // Test relationships
    expect($position->election->id)->toBe($election->id);
    expect($election->positions->first()->id)->toBe($position->id);
});
