<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LessonsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('lessons')->insert([
            [
                'registration_id' => 1,
                'instructor_id' => 1,
                'car_id' => 1,
                'start_date' => now(),
                'start_time' => '10:00:00',
                'end_date' => now(),
                'end_time' => '11:00:00',
                'lesson_status' => 'Scheduled',
                'goal' => 'Parking practice',
                'student_comment' => 'Looking forward to it',
                'instructor_comment' => 'Focus on reversing',
                'is_active' => true,
                'remark' => 'Morning session',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'registration_id' => 2,
                'instructor_id' => 2,
                'car_id' => 2,
                'start_date' => now()->addDays(1),
                'start_time' => '14:00:00',
                'end_date' => now()->addDays(1),
                'end_time' => '15:00:00',
                'lesson_status' => 'Scheduled',
                'goal' => 'Highway driving',
                'student_comment' => 'Excited to learn',
                'instructor_comment' => 'Focus on merging',
                'is_active' => true,
                'remark' => 'Afternoon session',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
