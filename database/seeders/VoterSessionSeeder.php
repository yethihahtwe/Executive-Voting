<?php

namespace Database\Seeders;

use App\Models\Voter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VoterSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $voters = Voter::all()->pluck('id');

        foreach ($voters as $voterId) {
            DB::table('voter_sessions')->insert([
                'voter_id' => $voterId,
                'session_id' => Str::random(40),
                'device_info' => fake()->userAgent(),
                'ip_address' => fake()->ipv4(),
                'last_activity' => fake()->dateTimeThisMonth(),
                'is_active' => true,
            ]);
        }
    }
}
