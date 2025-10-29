<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlumniCurrentEmploymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('alumni_current_employment')->insert([
            [
                'user_id' => 2,
                'company_name' => 'Pasig Data Center',
                'position_title' => 'Data Analyst',
                'location_id' => 3,
                'start_date' => '2024-01-05',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
