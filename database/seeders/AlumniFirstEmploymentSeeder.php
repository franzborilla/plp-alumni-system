<?php


namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AlumniFirstEmploymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('alumni_first_employment')->insert([
            [
                'user_id' => 2,
                'company_name' => 'PLDT Inc.',
                'position_title' => 'Network Engineer',
                'location_id' => 1,
                'industry_id' => 3,
                'job_alignment' => 'highly-related',
                'job_type' => 'full-time',
                'waiting_period' => '4-6 months',
                'start_date' => '2023-11-09',
                'end_date' => '2024-10-03',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'company_name' => 'PLDT Inc.',
                'position_title' => 'IT Administrator',
                'location_id' => 1,
                'industry_id' => 3,
                'job_alignment' => 'highly-related',
                'job_type' => 'full-time',
                'waiting_period' => '4-6 months',
                'start_date' => '2020-11-09',
                'end_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
