<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'user_id' => 2,
                'name' => 'Admin',
                'is_active' => true,
                'remark' => 'Administrator role',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'name' => 'Instructor',
                'is_active' => true,
                'remark' => 'Instructor role',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'name' => 'Student',
                'is_active' => true,
                'remark' => 'Student role',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
