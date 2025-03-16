<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('positions')->insert([
            [
                'title' => 'Chair-person',
                'description' => 'Chair-person of the Executive Body',
                'election_id' => 1,
                'is_active' => true
            ],
            [
                'title' => 'Vice Chair-person',
                'description' => 'Vice Chair-person of the Executive Body',
                'election_id' => 1,
                'is_active' => true
            ],
            [
                'title' => 'Secretary',
                'description' => 'Secretary of the Executive Body',
                'election_id' => 1,
                'is_active' => true
            ],
            [
                'title' => 'Joint Secretary',
                'description' => 'Joint Secretary of the Executive Body',
                'election_id' => 1,
                'is_active' => true
            ],
            [
                'title' => 'Treasurer',
                'description' => 'Treasurer of the Executive Body',
                'election_id' => 1,
                'is_active' => true
            ],
        ]);
    }
}
