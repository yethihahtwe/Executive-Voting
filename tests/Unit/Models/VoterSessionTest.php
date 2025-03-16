<?php

test('voter session belongs to a voter', function () {
    $voter = App\Models\Voter::factory()->create();
    
    $session = App\Models\VoterSession::factory()
        ->for($voter)
        ->create();
        
    expect($session->voter->id)->toBe($voter->id);
});

test('voter session tracks activity', function () {
    $voter = App\Models\Voter::factory()->create();
    
    // Create an active session
    $activeSession = App\Models\VoterSession::factory()
        ->active()
        ->for($voter)
        ->create();
        
    // Create an inactive session
    $inactiveSession = App\Models\VoterSession::factory()
        ->inactive()
        ->for($voter)
        ->create();
    
    expect($activeSession->is_active)->toBeTrue()
        ->and($inactiveSession->is_active)->toBeFalse();
});

test('voter session stores device information', function () {
    $voter = App\Models\Voter::factory()->create();
    
    $deviceInfo = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36';
    $ipAddress = '192.168.1.1';
    
    $session = App\Models\VoterSession::factory()
        ->for($voter)
        ->create([
            'device_info' => $deviceInfo,
            'ip_address' => $ipAddress
        ]);
        
    expect($session->device_info)->toBe($deviceInfo)
        ->and($session->ip_address)->toBe($ipAddress);
});
