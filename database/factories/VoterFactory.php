<?php

namespace Database\Factories;

use App\Models\Election;
use App\Models\Organization;
use App\Models\Voter;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoterFactory extends Factory
{
    protected $model = Voter::class;

    public function definition(): array
    {
        return [
            'voter_id' => strtoupper(fake()->bothify('???###')), // Format like ABC123
            'organization_id' => Organization::factory(),
            'election_id' => Election::factory(),
            'has_voted' => fake()->boolean(30), // 30% chance of having voted already
            'voted_at' => function (array $attributes) {
                return $attributes['has_voted'] ? fake()->dateTimeThisMonth() : null;
            },
        ];
    }

    /**
     * Indicate that the voter has already voted.
     */
    public function hasVoted(): static
    {
        return $this->state(fn (array $attributes) => [
            'has_voted' => true,
            'voted_at' => fake()->dateTimeThisMonth(),
        ]);
    }

    /**
     * Indicate that the voter has not voted yet.
     */
    public function hasNotVoted(): static
    {
        return $this->state(fn (array $attributes) => [
            'has_voted' => false,
            'voted_at' => null,
        ]);
    }
}
