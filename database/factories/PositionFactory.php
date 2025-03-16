<?php

namespace Database\Factories;

use App\Models\Election;
use App\Models\Position;
use App\Models\Representative;
use Illuminate\Database\Eloquent\Factories\Factory;

class PositionFactory extends Factory
{
    protected $model = Position::class;

    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle(),
            'description' => fake()->paragraph(),
            'election_id' => Election::factory(),
            'is_active' => fake()->boolean(80), // 80% chance of being active
            'is_completed' => fake()->boolean(20), // 20% chance of being completed
            'elected_representative_id' => null, // Default to null, will be set after voting
        ];
    }

    /**
     * Indicate that the position is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
            'is_completed' => false,
        ]);
    }

    /**
     * Indicate that the position has been completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
            'is_completed' => true,
            'elected_representative_id' => Representative::factory(),
        ]);
    }
}
