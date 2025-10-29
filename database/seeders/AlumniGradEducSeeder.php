<?php


namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AlumniGradEducSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('alumni_graduate_education')->insert([
            [
                'user_id' => 2,
                'level' => 'Masteral',
                'degree_title' => 'Master of Engineering in Electronics',
                'school' => 'Pamantasan ng Lungsod ng Pasig',
                'inclusive_years' => '2024-2025',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'level' => 'doctoral',
                'degree_title' => 'DIT',
                'school' => 'Pamantasan ng Lungsod ng Pasig',
                'inclusive_years' => '2024-2025',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'level' => 'doctoral',
                'degree_title' => 'DIT',
                'school' => 'University of the Philippines',
                'inclusive_years' => '2022-2023',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
