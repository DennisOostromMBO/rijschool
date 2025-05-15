<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixUserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear any existing role_user entries for these users to avoid duplicates
        DB::table('role_user')->whereIn('user_id', [1, 2, 3])->delete();

        // Reassign roles through the pivot table
        DB::table('role_user')->insert([
            [
                'user_id' => 1, // John Doe
                'role_id' => 1, // Admin role
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // Jane Smith
                'role_id' => 2, // Instructor role
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3, // Alice Johnson
                'role_id' => 3, // Student role
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
