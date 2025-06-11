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
                'relation_number' => 'LEER001',
                'is_active' => true,
                'remark' => 'First student',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'relation_number' => 'LEER002',
                'is_active' => true,
                'remark' => 'Second student',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
