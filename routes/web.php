<?php

use App\Http\Controllers\ResultsController;
use App\Http\Controllers\VotingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// V O T I N G  R O U T E S
Route::controller(VotingController::class)->group(function() {
    // Displays voter verification form
    Route::get('/vote', 'index')->name('vote.index');

    // voter verification
    Route::post('/vote/verify', 'verifyVoter')->name('vote.verify');

    // Ballot of the voter
    Route::get('/vote/{voter}', 'showBallot')->name('vote.ballot');

    // Voter submission
    Route::post('/vote/{voter}/submit', 'submitVote')->name('vote.submit');

    // Confirmation page show to the voter
    Route::get('/vote/confirmation', 'confirmation')->name('vote.confirmation');
});

// R E S U L T S  R O U T E S
Route::controller(ResultsController::class)->group(function() {
    // 
    Route::get('/results', 'index')->name('results.index');

    // Final results of a particular election
    Route::get('/results/{election}', 'show')->name('results.show');

    // Live result page of a particular election
    Route::get('/results/{election}/live', 'liveResults')->name('results.live');
});