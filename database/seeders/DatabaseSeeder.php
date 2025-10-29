<?php

namespace Database\Seeders;

use App\Models\AlumniBasicDetail;
use App\Models\AlumniBasicDetails;
use App\Models\AlumniCurrentEmployment;
use App\Models\AlumniEducation;
use App\Models\AlumniFirstEmployment;
use App\Models\AlumniPastEmployment;
use Illuminate\Support\Facades\DB;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        $this->call([
                        ReferenceTablesSeeder::class,
            UsersSeeder::class,
            AlumniDetailsSeeder::class,
            AlumniEducationSeeder::class,
            AlumniGradEducSeeder::class,
            AlumniFirstEmploymentSeeder::class,
            AlumniCurrentEmploymentSeeder::class,
            AlumniPastEmploymentSeeder::class,
            SkillSeeder::class,
            JobDetailSeeder::class,
            JobSkillSeeder::class,
            AlumniSkillSeeder::class,
            ForumSeeder::class,
            ForumCommentSeeder::class,
            EventDetailsTableSeeder::class,
            EventAttendeesTableSeeder::class,
            SubmittedJobSeeder::class,
            AuditLogsSeeder::class,
        ]);
    }
}