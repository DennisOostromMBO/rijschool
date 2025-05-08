<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('exams')->insert([
            [
                'registration_id' => 1,
                'instructor_id' => 1,
                'start_date' => now(),
                'start_time' => '09:00:00',
                'end_date' => now(),
                'end_time' => '10:00:00',
                'location' => 'Exam Center A',
                'result' => 'Passed',
                'is_active' => true,
                'comment' => 'First exam attempt',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'registration_id' => 2,
                'instructor_id' => 2,
                'start_date' => now()->addDays(7),
                'start_time' => '13:00:00',
                'end_date' => now()->addDays(7),
                'end_time' => '14:00:00',
                'location' => 'Exam Center B',
                'result' => 'Failed',
                'is_active' => true,
                'comment' => 'Second exam attempt',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
