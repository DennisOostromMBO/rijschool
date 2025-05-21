<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Core data
            UsersTableSeeder::class,       // Create basic users
            RolesTableSeeder::class,       // Define available roles
            RoleUserTableSeeder::class,    // Connect users with roles
            EnsureRoleAssignmentsSeeder::class, // Extra safety to guarantee role assignments

            // User-related data
            ContactsTableSeeder::class,
            StudentsTableSeeder::class,
            InstructorsTableSeeder::class,

            // Business logic data
            CarsTableSeeder::class,
            PackagesTableSeeder::class,
            RegistrationsTableSeeder::class,
            LessonsTableSeeder::class,
            PickupAddressesTableSeeder::class,
            PickupAddressesPerLessonTableSeeder::class,
            ExamsTableSeeder::class,

            // Financial data
            InvoicesTableSeeder::class,
            PaymentsTableSeeder::class,

            // Notifications
            NotificationsTableSeeder::class,
        ]);
    }
}
