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
                'user_id' => 1,
                'number' => 'INST001',
                'is_active' => true,
                'remark' => 'Main instructor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // ...add more instructors as needed...
        ]);
    }
}
