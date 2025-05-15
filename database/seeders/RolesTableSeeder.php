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
                'name' => 'Admin',
                'is_active' => true,
                'remark' => 'Administrator role',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Instructor',
                'is_active' => true,
                'remark' => 'Instructor role',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Student',
                'is_active' => true,
                'remark' => 'Student role',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
