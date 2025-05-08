<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('students')->insert([
            [
                'user_id' => 1,
                'relation_number' => 'REL12345',
                'is_active' => true,
                'remark' => 'First student',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // ...add more students as needed...
        ]);
    }
}
