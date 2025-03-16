<?php

namespace Database\Factories;

use App\Models\Election;
use Illuminate\Database\Eloquent\Factories\Factory;

class ElectionFactory extends Factory
{
    protected $model = Election::class;

    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('now', '+1 month');
        $endDate = fake()->dateTimeBetween($startDate, '+2 months');
        
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_active' => fake()->boolean(80), // 80% chance of being active
            'completed' => fake()->boolean(20), // 20% chance of being completed
        ];
    }

    /**
     * Indicate that the election is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
            'completed' => false,
        ]);
    }

    /**
     * Indicate that the election is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
            'completed' => true,
        ]);
    }
}
