<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Position;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultsController extends Controller
{
    // Show a list of elections and their results
    public function index()
    {
        $elections = Election::orderBy('start_date', 'desc')->get();

        // Get currently active election
        $activeElection = $elections->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        // Get completed elections
        $completedElections = $elections->where('completed', true);

        // Get the view
        return view('results.index', [
            'activeElection' => $activeElection,
            'completedElections' => $completedElections,
        ]);
    }

    // Show the results of a particular election
    public function show(Election $election)
    {
        // Check if the election is expired by the election time but not completed yet due to counting ballots are not finished
        // If the elelction is still active when time is not expired, it will show the live results though it is not completed yet
        if (!$election->is_active && !$election->completed) {
            return redirect()->route('results.index')
                ->with('error', 'Results are not available for this election yet');
        }
    }

    // Get election results
    private function getElectionResults(Election $election)
    {
        // Get positions order by completion status, then by active status, then by id
        $positions = Position::where('election_id', $election->id)
            ->orderByRaw('CASE
                WHEN is_completed = 1 THEN 0
                WHEN is_active = 1 THEN 1
                ELSE 2
                END')
            ->orderBy('id')
            ->get();

        // Initiate empty results
        $results = [];

        foreach ($positions as $position) {
            // Get their vote counts and representative details
            $positionResults = DB::table('votes')
                ->select(
                    'representatives.id as representative_id',
                    'representatives.name as representative_name',
                    'organizations.id as organization_id',
                    'organizations.name as organization_name',
                    DB::raw('COUNT(*) as vote_count')
                )
                ->where('votes.position_id', $position->id)
                ->where('votes.election_id', $election->id)
                ->join('representatives', 'votes.representative_id', '=', 'representatives.id')
                ->leftJoin('organizations', 'representatives.organization_id', '=', 'organizations.id')
                ->groupBy(
                    'representatives.id',
                    'representatives.name',
                    'organizations.id',
                    'organizations.name'
                )
                ->orderByDesc('vote_count')
                ->get();

            // Format the query results into array
            $formattedResults = $positionResults->map(function ($result) {
                return [
                    'representative' => (object)[
                        'id' => $result->representative_id,
                        'name' => $result->representative_name,
                        'organization_id' => $result->organization_id,
                    ],
                    'organization' => $result->organization_id ? (object)[
                        'id' => $result->organization_id,
                        'name' => $result->organization_name,
                    ] : null,
                    'vote_count' => $result->vote_count,
                ];
            });

            // Check if there's a tie for most voted positions
            $maxVotes = $formattedResults->isEmpty() ? 0 : $formattedResults->max('vote_count');
            $tiedCandidates = $formattedResults->where('vote_count', $maxVotes)->count();

            // Get elected representative if the position is completed
            $electedRepresentative = null;
            if ($position->is_completed && $position->elected_representative_id) {
                $electedRepresentative = DB::table('representatives')
                    ->select(
                        'representatives.*',
                        'organizations.id as organization_id',
                        'organizations.name as organization_name'
                    )
                    ->leftJoin('organizations', 'representatives.organization_id', '=', 'organizations.id')
                    ->where('representatives.id', $position->elected_representative_id)
                    ->first();
            }

            // Assign the array
            $results[$position->id] = [
                'position' => $position,
                'results' => $formattedResults,
                'has_tie' => $tiedCandidates > 1,
                'total_votes' => $formattedResults->sum('vote_count'),
                'is_active' => $position->is_active,
                'is_completed' => $position->is_completed,
                'elected_representative' => $electedRepresentative
            ];
        }

        return $results;
    }
}
