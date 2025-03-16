<?php

namespace Database\Factories;

use App\Models\Voter;
use App\Models\VoterSession;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VoterSessionFactory extends Factory
{
    protected $model = VoterSession::class;

    public function definition(): array
    {
        return [
            'voter_id' => Voter::factory(),
            'session_id' => Str::random(40),
            'device_info' => fake()->userAgent(),
            'ip_address' => fake()->ipv4(),
            'last_activity' => fake()->dateTimeThisMonth(),
            'is_active' => fake()->boolean(70), // 70% chance of being active
        ];
    }

    /**
     * Indicate that the session is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
            'last_activity' => now(),
        ]);
    }

    /**
     * Indicate that the session is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
            'last_activity' => fake()->dateTimeBetween('-1 month', '-1 day'),
        ]);
    }
}
