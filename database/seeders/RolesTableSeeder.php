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
                'user_id' => 1,
                'name' => 'Admin',
                'is_active' => true,
                'remark' => 'Administrator role',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'name' => 'Instructor',
                'is_active' => true,
                'remark' => 'Instructor role',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
