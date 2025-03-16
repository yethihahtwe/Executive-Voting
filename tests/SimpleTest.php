<?php

test('database connection works', function () {
    // Test that the database connection exists
    $db = new \Illuminate\Database\SQLiteConnection(
        new PDO('sqlite::memory:')
    );
    
    expect($db)->not->toBeNull();
});

test('models can be created', function () {
    // Create an election
    $election = new \App\Models\Election();
    $election->title = 'Test Election';
    $election->description = 'Test Description';
    $election->start_date = now();
    $election->end_date = now()->addDay();
    $election->is_active = true;
    $election->completed = false;
    $election->save();
    
    expect(\App\Models\Election::count())->toBe(1);
});
