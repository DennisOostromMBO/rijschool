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
                'target_group' => 'Student',
                'message' => 'Lesson rescheduled',
                'notification_type' => 'LessonChange',
                'date' => now(),
                'is_active' => true,
                'remark' => 'Urgent notification',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // ...add more notifications as needed...
        ]);
    }
}
