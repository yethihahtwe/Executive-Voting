<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Voter;
use App\Models\Election;
use App\Models\Position;
use Illuminate\Support\Str;
use App\Models\VoterSession;
use Illuminate\Http\Request;
use App\Models\Representative;
use Illuminate\Support\Facades\DB;

class VotingController extends Controller
{
    // Voter verification form
    public function index()
    {
        // Check if there's an active election
        $activeElection = self::getActiveElection();

        // If no active election right now, show no active election page
        if (!$activeElection) {
            return view('voting.no-active-election');
        }

        // Check if there is an active position for voting
        $activePosition = self::getActivePosition($activeElection);
        // If there is not active position, redirect back
        if (!$activePosition) {
            return view('voting.no-active-position', [
                'election' => $activeElection,
            ]);
        }
        // show voter verification page if there is an active election
        return view('voting.index', [
            'election' => $activeElection,
            'activePosition' => $activePosition,
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

        // The election is then active, but we still need to check if there is an active position vote
        $activePosition = Position::where('election_id', $election->id)
            ->where('is_active', true)
            ->first();

        // If there is not active position vote even when the election is active, redirect the user back
        if (!$activePosition) {
            return back()->withErrors([
                'position' => 'There is no active position for voting at this time.'
            ]);
        }
        // The voter has active election and an active position so far
        // Check if the user has voted for this position
        $hasVotedforThisPosition = Vote::where('voter_id', $voter->id)
            ->where('position_id', $activePosition->id)
            ->exists();

        // If the user has voted for this position, show error
        if ($hasVotedforThisPosition) {
            return back()->withErrors([
                'voter_id' => 'You have already voted for this position'
            ]);
        }

        // The user is verified and there is an active position in this stage, can go to ballots page now for this active position
        return redirect()->route('vote.ballot', [$voter->id, $activePosition->id]);
    }

    // Show the voting ballots for a particular position to the voter
    public function showBallot(Voter $voter, Position $position)
    {
        // Check if there is an active session and redirect back
        $session = self::checkActiveSession($voter);

        // The session can either return a redirect response or a VoterSession
        if ($session instanceof \Illuminate\Http\RedirectResponse) {
            return $session;
        }

        // If there's an active session, extend the last active timestamp
        $session->update(['last_activity' => now()]);

        // Get details of the election for display
        $election = $voter->election;

        // Making sure the position currently visited by the voter is active and belongs to the current election.
        self::checkActivePosition($position, $election);

        // Check if the voter has already voted for this position and redirect if voted
        self::checkPositionVoted($voter, $position);

        // Get elected representatives
        $electedRepresentatives = self::getElectedRepresentatives($election);

        // Get excluded organization Ids
        $excludedOrganizationIds = self::getExcludedOrganizations($electedRepresentatives);

        // Get eligible representatives
        // Excluding organizations that have their representatives elected
        $eligibleRepresentatives = Representative::whereHas('organization', function ($query) use ($excludedOrganizationIds) {
            // If excludedOrganizationIds is not empty, will query from it
            if (!empty($excludedOrganizationIds)) {
                $query->whereNotIn('id', $excludedOrganizationIds);
            }
        })
            ->with('organization')
            ->get();

        // Now we have eligible representatives, we can show it to the voter
        return view('voting.ballot', [
            'voter' => $voter,
            'election' => $election,
            'position' => $position,
            'representatives' => $eligibleRepresentatives,
            'electedPositions' => $electedRepresentatives,
        ]);
    }

    // Show confirmation dialog
    public function confirmVote(Request $request, Voter $voter, Position $position)
    {
        // Validate that a representative was selected
        if (!$request->has('representative_id') || empty($request->representative_id)) {
            return response()->view('voting.validation-error', [
                'error' => 'Please select a representative before submitting your vote.'
            ]);
        }
        // Check if the requested representative exists in the database
        $representative = Representative::find($request->representative_id);
        if (!$representative) {
            return response()->view('voting.validation-error', [
                'error' => 'The selected representative is invalid.'
            ]);
        }

        return view('voting.confirm', [
            'voter' => $voter,
            'position' => $position,
            'representativeId' => $request->representative_id
        ]);
    }

    // Cancel confirmation (return empty response)
    public function cancelConfirm()
    {
        return response('');
    }


    // Processing the vote submitted by the user
    public function submitVote(Request $request, Voter $voter, Position $position)
    {
        // Check if there is an active session
        $session = self::checkActiveSession($voter);

        // If $session is a redirect response, return it immediately
        if ($session instanceof \Illuminate\Http\RedirectResponse) {
            return $session;
        }

        // Get details of the election
        $election = $voter->election;

        // Make sure the position is active and belongs to the current election
        self::checkActivePosition($position, $election);

        // Check if the voter has already voted for this position
        self::checkPositionVoted($voter, $position);

        // Validate the voter selected form data
        $request->validate([
            'representative_id' => 'required|exists:representatives,id',
        ]);

        // Get previously elected representatives
        $electedRepresentatives = self::getElectedRepresentatives($election);

        // Get excluded organizations
        $excludedOrganizationIds = self::getExcludedOrganizations($electedRepresentatives);


        // Now the request has been validated, it's time to check whether voter selected representative is eligible
        // Get representative object from voter selected representative and eager load their organization
        $selectedRepresentative = Representative::with('organization')
            ->findOrFail($request->representative_id);

        // If voter selected representative's organizatoin belongs to one of the excluded organizations, redirect back with error
        if (in_array($selectedRepresentative->organization_id, $excludedOrganizationIds)) {
            return back()->withErrors([
                'ineligible' => 'This representative\'s organization already has an elected member.'
            ]);
        }

        // The validation process has made this far, now it is time to carry out the database transaction
        DB::beginTransaction();

        try {
            // insert the vote
            Vote::create([
                'voter_id' => $voter->id,
                'representative_id' => $request->representative_id,
                'position_id' => $position->id,
                'election_id' => $election->id
            ]);

            // Insert is successful, let us extend the user last active timestamp
            $session->update(['last_activity' => now()]);

            // Commit the transaction
            DB::commit();

            // Database transaction is completed, redirect to confirmation page
            return redirect()->route('vote.confirmation');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors([
                'submission' => 'There was an error submitting your vote. Please try again.'
            ]);
        }
    }

    // Show voting confirmation page
    public function confirmation(Request $request)
    {
        // Get active election
        $activeElection = self::getActiveElection();

        if (!$activeElection) {
            return view('voting.confirmation');
        }

        $activePosition = Position::where('election_id', $activeElection->id)
            ->where('is_active', true)
            ->first();

        $completedPositions = Position::where('election_id', $activeElection->id)
            ->where('is_completed', true)
            ->with('electedRepresentative.organization')
            ->get();

        return view('voting.confirmation', [
            'election' => $activeElection,
            'activePosition' => $activePosition,
            'completedPositions' => $completedPositions
        ]);
    }

    // check if there is an active election

    protected function getActiveElection(): Election|null
    {
        return Election::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
    }

    // Check if there is an active position
    protected function getActivePosition($activeElection)
    {
        return Position::where('election_id', $activeElection->id)
            ->where('is_active', true)
            ->first();
    }

    // Reusable function to check active session and redirect if not
    protected function checkActiveSession(Voter $voter)
    {
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



    // Making sure the position currently visited by the voter is active and belongs to the current election.
    protected function checkActivePosition(Position $position, Election $election)
    {
        if (!$position->is_active || $position->election_id != $election->id) {
            return redirect()->route('vote.index')
                ->withErrors(['position' => 'This position is not currently available for this election.']);
        }
    }


    // Check if the voter has already voted for this position and redirect if voted
    protected function checkPositionVoted(Voter $voter, Position $position)
    {
        $hasVotedForThisPosition = Vote::where('voter_id', $voter->id)
            ->where('position_id', $position->id)
            ->exists();

        // If the voter has already voted for this position, redirect to voting index page
        if ($hasVotedForThisPosition) {
            return redirect()->route('vote.index')
                ->withErrors(['already_voted' => 'You have already voted for this position.']);
        }
    }

    // Get elected representatives
    protected function getElectedRepresentatives(Election $election)
    {
        return Position::where('election_id', $election->id)
            ->where('is_completed', true)
            ->whereNotNull('elected_representative_id')
            ->with('electedRepresentative.organization')
            ->get();
    }

    // Get excluded organizations
    protected function getExcludedOrganizations($electedRepresentatives): array
    {
        // Get Organization IDs that have representatives elected
        $excludedOrganizationIds = $electedRepresentatives->pluck('electedRepresentative.organization_id')
            ->unique()
            ->toArray();

        return $excludedOrganizationIds;
    }
}
