<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('organizations')->insert([
            [
                'name' => 'Burma Medical Association',
                'abbreviation' => 'BMA',
            ],
            [
                'name' => 'Backpack Health Worker Team',
                'abbreviation' => 'BPHWT',
            ],
            [
                'name' => 'ChinLung Health Institute',
                'abbreviation' => 'CHI',
            ],
            [
                'name' => 'Civil Health and Development Network - Karenni',
                'abbreviation' => 'CHDN',
            ],
            [
                'name' => 'Kachin Health Network',
                'abbreviation' => 'KHN',
            ],
            [
                'name' => 'Kachin Women\'s Association - Thailand',
                'abbreviation' => 'KWAT',
            ],
            [
                'name' => 'Karen Development of Health and Welfare',
                'abbreviation' => 'KDHW',
            ],
            [
                'name' => 'Mon National Health Committee',
                'abbreviation' => 'MNHC',
            ],
            [
                'name' => 'Mae Tao Clinic',
                'abbreviation' => 'MTC',
            ],
            [
                'name' => 'Pa-Oh Health Working Committee',
                'abbreviation' => 'PHWC',
            ],
            [
                'name' => 'Shan Health Committee',
                'abbreviation' => 'SHC',
            ],
            [
                'name' => 'Ta\'ang Health Organization',
                'abbreviation' => 'THO',
            ],
        ]);
    }
}
