<?php

use Illuminate\Support\Facades\Route;

// Define some test routes that we can use in our tests
Route::post('vote/verify', function () {
    $voterId = request('voter_id');
    $voter = \App\Models\Voter::where('voter_id', $voterId)->first();
    
    if (!$voter) {
        return redirect()->back()->withErrors(['voter_id' => 'Voter not found']);
    }
    
    $firstPosition = $voter->election->positions->first();
    
    return redirect()->route('vote.ballot', [
        'voter' => $voter->id,
        'position' => $firstPosition ? $firstPosition->id : 0
    ]);
})->name('vote.verify');

Route::get('vote/{voter}/{position}', function ($voter, $position) {
    return view('vote.ballot');
})->name('vote.ballot');

Route::post('vote/{voter}/{position}/submit', function ($voter, $position) {
    $voterModel = \App\Models\Voter::find($voter);
    
    if (!$voterModel) {
        return redirect()->back()->withErrors(['voter' => 'Voter not found']);
    }
    
    if ($voterModel->has_voted) {
        return redirect()->back()->withErrors(['voter' => 'Voter has already voted']);
    }
    
    // Create a vote
    \App\Models\Vote::create([
        'voter_id' => $voter,
        'position_id' => $position,
        'representative_id' => request('representative_id'),
        'election_id' => $voterModel->election_id
    ]);
    
    // Update voter status
    $voterModel->update([
        'has_voted' => true,
        'voted_at' => now()
    ]);
    
    return redirect()->route('vote.confirmation');
})->name('vote.submit');

Route::get('vote/confirmation', function () {
    return view('vote.confirmation');
})->name('vote.confirmation');

Route::get('results/{election}/live', function ($election) {
    return view('results.live', ['election' => \App\Models\Election::find($election)]);
})->name('results.live');

Route::get('results/{election}', function ($election) {
    return view('results.show', ['election' => \App\Models\Election::find($election)]);
})->name('results.show');

// Mock route for HTMX tests
Route::post('vote/select-candidate', function () {
    return response()->json(['selected' => true]);
})->name('vote.select-candidate');

Route::get('results/{election}/live/update', function () {
    return response()->json(['updated' => true]);
})->name('results.live.update');

// Mock Filament routes for tests
Route::prefix('admin')->name('filament.resources.')->group(function () {
    Route::prefix('elections')->name('elections.')->group(function () {
        Route::get('create', function () {
            return response('Create Election Page');
        })->name('create');
        
        Route::post('/', function () {
            \App\Models\Election::create(request()->all());
            return redirect()->route('filament.resources.elections.index');
        })->name('store');
        
        Route::get('/', function () {
            return response('Elections Index');
        })->name('index');
    });
    
    Route::prefix('voters')->name('voters.')->group(function () {
        Route::get('create', function () {
            return response('Create Voter Page');
        })->name('create');
        
        Route::post('/', function () {
            \App\Models\Voter::create(request()->all());
            return redirect()->route('filament.resources.voters.index');
        })->name('store');
        
        Route::get('/', function () {
            return response('Voters Index');
        })->name('index');
    });
    
    Route::prefix('representatives')->name('representatives.')->group(function () {
        Route::get('create', function () {
            return response('Create Representative Page');
        })->name('create');
        
        Route::post('/', function () {
            \App\Models\Representative::create(request()->all());
            return redirect()->route('filament.resources.representatives.index');
        })->name('store');
        
        Route::get('/', function () {
            return response('Representatives Index');
        })->name('index');
    });
});
