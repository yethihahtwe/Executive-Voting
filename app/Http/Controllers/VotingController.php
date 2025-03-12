<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Representative;
use App\Models\Voter;
use App\Models\VoterSession;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VotingController extends Controller
{
    // Voter verification form
    public function index()
    {
        // Check if there's an active election
        $activeElection = Election::where('is_active', true)
        ->where('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->first();

        // If no active election right now, show no active election page
        if (!$activeElection) {
            return view('voting.no-active-election');
        }

        // show voter verification page if there is an active election
        return view('voting.index', [
            'election' => $activeElection
        ]);
    }

    // voter verification and create session
    public function verifyVoter(Request $request)
    {
        // validate voter id entered by the user
        $request->validate([
            'voter_id' => 'required|string'
        ]);

        // query the database table with user entered voter id
        $voter = Voter::where('voter_id', $request->voter_id)->first();

        // If there is no predefined voter id or mismatch, return error
        if (!$voter) {
            return back()->withErrors([
                'voter_id' => 'Invalid voter ID. Please try again.'
            ]);
        }

        // Check if voter has already voted
        if ($voter->has_voted) {
            return back()->withErrors([
                'voter_id' => 'You have already voted for this election.'
            ]);
        }

        // Check if the election is active
        $election = $voter->election;
        if (!$election->is_active || now() < $election->start_date || now() > $election->end_date) {
            return back()->withErrors([
                'voter_id' => 'The election is currently closed.'
            ]);
        }

        // Otherwise, create or update voter session
        $session = VoterSession::updateOrCreate(
            ['voter_id' => $voter->id],
            [
                'session_id' => Str::uuid(),
                'device_info' => $request->userAgent(),
                'ip_address' => $request->ip(),
                'last_activity' => now(),
                'is_active' => true
            ]
            );

        // Then return to ballots
        return redirect()->route('vote.ballot', $voter->id);
    }

    // Show the voting ballots to the voter
    public function showBallot(Voter $voter)
    {
        // Check if there is an active session
        $session = self::checkActiveSession($voter);

        // If there's an active session, extend the last active timestamp
        $session->update(['last_activity' => now()]);

        // Get details of the election for display
        $election = $voter->election;
        // Get positions offered by the election
        $positions = $election->positions;

        // Get eligible representatives
        // Organizations are eager loaded to make sure 5 executives were from different organizations
        $representatives = Representative::whereHas('organization')
        ->with('organization')
        ->get()
        ->groupBy('organization_id');

        return view('voting.ballot', [
            'voter' => $voter,
            'election' => $election,
            'positions' => $positions,
            'representative' => $representatives
        ]);
    }

    // Processing the vote submitted by the user
    public function submitVote(Request $request, Voter $voter) {
        // Check if there is an active session
        $session = self::checkActiveSession($voter);
    }

    // Reusable function to check active session and redirect if not
    protected function checkActiveSession(Voter $voter) {
        // Ensure if there is an active session
        $session = VoterSession::where('voter_id', $voter->id)
        ->where('is_active', true)
        // the session will expire after 30 minutes of inactivity
        ->where('last_activity', '>=', now()->subMinutes(30))
        ->first();

        // If there is no active session, redirect to voter verification page
        if (!$session) {
            return redirect()->route('vote.index')
            ->withErrors(['session' => 'Your session has expired. Please verify your voter ID again.']);
        }
        return $session;
    }
}
