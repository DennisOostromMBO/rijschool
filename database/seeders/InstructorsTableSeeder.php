<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstructorsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('instructors')->insert([
            [
                'user_id' => 3,
                'number' => 'INST001',
                'is_active' => true,
                'remark' => 'Main instructor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'number' => 'INST002',
                'is_active' => true,
                'remark' => 'Backup instructor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
