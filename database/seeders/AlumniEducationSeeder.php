<?php


namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AlumniEducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('alumni_education')->insert([
            [
                'user_id' => 2,
                'student_number' => '18-00276',
                'course_id' => 13,
                'year_graduated' => '2023',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'student_number' => '17-00276',
                'course_id' => 12,
                'year_graduated' => '2020',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
