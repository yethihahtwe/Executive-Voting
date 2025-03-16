<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = Organization::all();

        foreach ($organizations as $organization) {
            $organizationId = $organization->id;
            $abbr = $organization->abbreviation;

            // Create 5 voters from each organization
            for ($i = 1; $i < 6; $i++) {
                DB::table('voters')->insert([
                    'voter_id' => $abbr . $i,
                    'organization_id' => $organizationId,
                    'election_id' => 1
                ]);
            }
        }
    }
}
