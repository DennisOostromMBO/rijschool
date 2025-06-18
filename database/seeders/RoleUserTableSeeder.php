<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assign roles to users
        // 1. John Doe - Admin role (role_id 1)
        // 2. Jane Smith - Instructor role (role_id 2)
        // 3. Alice Johnson - Student role (role_id 3)
        DB::table('role_user')->insert([
            [
                'user_id' => 1, // John Doe
                'role_id' => 1, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // Jane Smith
                'role_id' => 2, // Instructor
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3, // Alice Johnson
                'role_id' => 3, // Student
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
