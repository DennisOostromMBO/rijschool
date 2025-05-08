<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegistrationsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('registrations')->insert([
            [
                'student_id' => 1,
                'package_id' => 1,
                'start_date' => now(),
                'end_date' => null,
                'is_active' => true,
                'remark' => 'First registration',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 2,
                'package_id' => 2,
                'start_date' => now(),
                'end_date' => now()->addMonths(3),
                'is_active' => true,
                'remark' => 'Second registration',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
