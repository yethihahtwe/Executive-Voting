<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call individual seeders
        $this->call([
            OrganizationSeeder::class,
            AdminSeeder::class,
            ElectionSeeder::class,
            PositionSeeder::class,
            RepresentativeSeeder::class,
            VoterSeeder::class,
          //  VoterSessionSeeder::class,
          //  VoteSeeder::class,
        ]);
    }
}
