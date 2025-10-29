<?php


namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AlumniDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('alumni_basic_details')->insert([
            [
                'user_id' => 2,
                'employment_status' => 'full-time',
                'birthdate' => '2000-05-18',
                'sex' => 'Male',
                'civil_status' => 'Single',
                'mobile_number' => '09392785702',
                'address' => 'Dr. Sixto Antonio Ave.',
                'about' => 'I am John Paul, a graduate of BS Electronics Engineering (BSECE) from Pamantasan ng Lungsod ng Pasig, Batch 2023. I am currently working as a Network Engineer at PLDT Inc., where I apply my technical knowledge and passion for telecommunications to real-world network solutions.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'employment_status' => 'full-time',
                'birthdate' => '1997-05-18',
                'sex' => 'Female',
                'civil_status' => 'Single',
                'mobile_number' => '09392785744',
                'address' => 'Bonifacio St.',
                'about' => 'I am Lexie, a graduate of BSIT from Pamantasan ng Lungsod ng Pasig, Batch 2024. I am currently working as a IT administrator PLDT Inc., where I apply my technical knowledge and passion for technology solutions.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
