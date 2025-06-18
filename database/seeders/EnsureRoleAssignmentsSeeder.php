<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnsureRoleAssignmentsSeeder extends Seeder
{
    /**
     * Run the database seeds to ensure all users have proper roles.
     * This provides a safety mechanism to guarantee role assignments.
     */
    public function run(): void
    {
        // First, clear all existing role assignments to avoid duplicates
        DB::table('role_user')->truncate();

        // User IDs with their respective roles
        $userRoles = [
            // Admin (only John Doe)
            1 => 1, // John Doe (user_id 1) = Admin role (role_id 1)

            // Instructors (5 users)
            2 => 2, // Jane Smith
            3 => 2, // Michael Brown
            4 => 2, // David van Berg
            5 => 2, // Laura Jansen
            6 => 2, // Mohamed Ahmed

            // Students (15 users)
            7 => 3,  // Alice Johnson
            8 => 3,  // Thomas Wilson
            9 => 3,  // Sara Vries
            10 => 3, // Lucas de Groot
            11 => 3, // Emma Bakker
            12 => 3, // Noah Peters
            13 => 3, // Lotte Visser
            14 => 3, // Daan van Dijk
            15 => 3, // Sophie Meijer
            16 => 3, // Tim Hendriks
            17 => 3, // Julia Boer
            18 => 3, // Max van der Meer
            19 => 3, // Fleur Dijkstra
            20 => 3, // Sven Smit
            21 => 3, // Isa Koning
        ];

        // Prepare role assignments for insertion
        $roleAssignments = [];

        foreach ($userRoles as $userId => $roleId) {
            $roleAssignments[] = [
                'user_id' => $userId,
                'role_id' => $roleId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert all role assignments at once
        DB::table('role_user')->insert($roleAssignments);
    }
}
