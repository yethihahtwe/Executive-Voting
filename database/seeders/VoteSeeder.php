<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\Representative;
use App\Models\Voter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $electionId = 1;
        $positions = Position::where('election_id', $electionId)->pluck('id');
        $voters = Voter::where('election_id', $electionId)->pluck('id');
        $representatives = Representative::all()->pluck('id')->toArray();

        foreach ($positions as $positionId) {

            foreach ($voters as $voterId) {
                $randomRepresentative = $representatives[array_rand($representatives)];

                DB::table('votes')->insert([
                    'voter_id' => $voterId,
                    'representative_id' => $randomRepresentative,
                    'position_id' => $positionId,
                    'election_id' => $electionId,
                ]);
            }
        }
    }
}
