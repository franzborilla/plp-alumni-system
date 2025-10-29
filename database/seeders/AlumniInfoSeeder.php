<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AlumniInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('alumni_information')->insert([
            [
                'last_name' => 'Morales',
                'first_name' => 'Joshua',
                'middle_name' => null,
                'suffix' => null,
                'sex' => 'male',
                'course_id' => 11,
                'birthdate' => '2003-02-05',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
