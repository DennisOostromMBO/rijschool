<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('notifications')->insert([
            [
                'user_id' => 1,
                'title' => 'Wijziging in lesschema',
                'target_group' => 'Student',
                'message' => 'Lesson rescheduled',
                'notification_type' => 'LessonChange',
                'date' => now(),
                'is_active' => true,
                'remark' => 'Urgent notification',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Nieuwe les toegewezen',
                'target_group' => 'Instructor',
                'message' => 'New lesson assigned',
                'notification_type' => 'LessonAssignment',
                'date' => now(),
                'is_active' => true,
                'remark' => 'Informative notification',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
