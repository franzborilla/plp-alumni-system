<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlumniPastEmploymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('alumni_past_employment')->insert([
            [
                'user_id' => 2,
                'company_name' => 'Metro Design Studio',
                'position_title' => 'Graphic Artist',
                'location_id' => 2,
                'inclusive_years' => '2019 - 2021',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
