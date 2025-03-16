<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ElectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('elections')->insert([
            [
                'title' => 'EHSSG Executive Body Election',
                'description' => 'Voting for Executive Body Formation by EHSSG Annual General Meeting',
                'start_date' => '2025-03-19 13:00:00',
                'end_date' => '2025-03-19 15:00:00',
                'is_active' => true,
                'completed' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
