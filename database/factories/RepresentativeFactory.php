<?php

namespace Database\Factories;

use App\Models\Organization;
use App\Models\Representative;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepresentativeFactory extends Factory
{
    protected $model = Representative::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'name' => fake()->name(),
        ];
    }
}
