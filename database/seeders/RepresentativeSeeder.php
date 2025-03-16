<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RepresentativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = Organization::all()->pluck('id');

        foreach ($organizations as $organizationId) {
            // Create 2 representatives from each organization
            for ($i = 0; $i < 2; $i++) {
                DB::table('representatives')->insert([
                    'organization_id' => $organizationId,
                    'name' => fake()->name(),
                ]);
            }
        }
    }
}
