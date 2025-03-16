<?php

namespace Database\Factories;

use App\Models\Election;
use App\Models\Position;
use App\Models\Representative;
use App\Models\Vote;
use App\Models\Voter;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteFactory extends Factory
{
    protected $model = Vote::class;

    public function definition(): array
    {
        // We're going to rely on the caller to provide these relationships
        return [
            'voter_id' => null,
            'representative_id' => null,
            'position_id' => null,
            'election_id' => null,
        ];
    }

    /**
     * Configure the vote with consistent relations.
     */
    public function configured(): static
    {
        return $this->state(function (array $attributes) {
            // Create an election
            $election = Election::factory()->create();
            
            // Create a position for this election
            $position = Position::factory()->create([
                'election_id' => $election->id
            ]);
            
            // Create a voter for this election
            $voter = Voter::factory()->create([
                'election_id' => $election->id
            ]);
            
            // Create a representative
            $representative = Representative::factory()->create();
            
            return [
                'voter_id' => $voter->id,
                'representative_id' => $representative->id,
                'position_id' => $position->id,
                'election_id' => $election->id,
            ];
        });
    }

    /**
     * Configure the vote for a specific election.
     */
    public function forElection(Election $election): static
    {
        return $this->state(function (array $attributes) use ($election) {
            // Create a position for this election if needed
            $position = Position::factory()->create([
                'election_id' => $election->id
            ]);
            
            // Create a voter for this election
            $voter = Voter::factory()->create([
                'election_id' => $election->id
            ]);
            
            // Create a representative
            $representative = Representative::factory()->create();
            
            return [
                'voter_id' => $voter->id,
                'representative_id' => $representative->id,
                'position_id' => $position->id,
                'election_id' => $election->id,
            ];
        });
    }
}
