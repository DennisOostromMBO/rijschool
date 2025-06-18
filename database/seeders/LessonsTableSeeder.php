<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Instructor;
use App\Models\Car;

class LessonsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure instructors and cars exist
        $instructor = Instructor::firstOrCreate(
            ['id' => 1],
            ['user_id' => 1, 'status' => 'active']
        );

        $car = Car::firstOrCreate(
            ['id' => 1],
            ['make' => 'Toyota', 'model' => 'Corolla', 'year' => 2020, 'license_plate' => 'ABC123', 'color' => 'Blue', 'transmission_type' => 'automatic', 'status' => 'available']
        );

        DB::table('lessons')->insert([
            [
                'registration_id' => 1,
                'instructor_id' => $instructor->id,
                'car_id' => $car->id,
                'start_date' => now(),
                'start_time' => '10:00:00',
                'end_date' => now(),
                'end_time' => '11:00:00',
                'lesson_status' => 'Gepland',
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
                'lesson_status' => 'Gepland',
                'goal' => 'Highway driving',
                'student_comment' => 'Excited to learn',
                'instructor_comment' => 'Focus on merging',
                'is_active' => true,
                'remark' => 'Afternoon session',
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
                'lesson_status' => 'Gepland',
                'goal' => 'Highway driving',
                'student_comment' => 'Excited to learn',
                'instructor_comment' => 'Focus on merging',
                'is_active' => true,
                'remark' => 'Afternoon session',
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
                'lesson_status' => 'Gepland',
                'goal' => 'Highway driving',
                'student_comment' => 'Excited to learn',
                'instructor_comment' => 'Focus on merging',
                'is_active' => true,
                'remark' => 'Afternoon session',
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
                'lesson_status' => 'Gepland',
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
