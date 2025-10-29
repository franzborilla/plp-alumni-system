<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('news_details')->insert([
            [
                'title' => 'Board Top Notcher',
                'description' => 'CONGRATULATIONS to our PLP-CBA Alumni for passing the October 2019 Certified Public Accountant (CPA) Licensure Examination! Jan Michael Vincent G. Esquivel, CPA; Eduardo Vic I. Salvador, CPA.',
                'image_path' => 'news1.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'University Shirt',
                'description' => 'University shirt now available for Alumni! The new design proudly represents the PLP spirit and is available in multiple sizes. Shirts are made of high-quality fabric, perfect for daily wear and events.',
                'image_path' => 'news2.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Transition Meeting',
                'description' => 'PLP Alumni Association, Inc. Transition Meeting for new officers. Thank you Sir Eric and your team for your dedication to serve our alumni. We look forward to making new leaps as an association.',
                'image_path' => 'news3.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
