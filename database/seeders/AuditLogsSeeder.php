<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AuditLogsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('audit_logs')->insert([
            [
                'user_id' => 1,
                'action' => 'Logged in to the system',
                'action_time' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'action' => 'Updated profile information',
                'action_time' => Carbon::now()->subMinutes(10),
            ],
            [
                'user_id' => 1,
                'action' => 'Created new event post',
                'action_time' => Carbon::now()->subHour(),
            ],
        ]);
    }
}
