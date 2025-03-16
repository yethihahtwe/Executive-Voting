<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationFactory extends Factory
{
    protected $model = Organization::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'abbreviation' => function (array $attributes) {
                // Generate abbreviation from company name
                $words = explode(' ', $attributes['name']);
                $abbreviation = '';
                foreach ($words as $word) {
                    $abbreviation .= strtoupper(substr($word, 0, 1));
                }
                return $abbreviation;
            },
        ];
    }
}
