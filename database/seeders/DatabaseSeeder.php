<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'Test',
            'middle_name' => null,
            'last_name' => 'User',
            'birth_date' => '1990-01-01',
            'username' => 'testuser',
            'password' => bcrypt('password123'),
            'is_logged_in' => false,
            'logged_in_at' => null,
            'logged_out_at' => null,
            'is_active' => true,
            'remark' => 'Seeder test user',
        ]);

        $this->call([
            UsersTableSeeder::class, // Ensure users are seeded first
            RolesTableSeeder::class,
            ContactsTableSeeder::class,
            StudentsTableSeeder::class,
            InstructorsTableSeeder::class,
            NotificationsTableSeeder::class,
            CarsTableSeeder::class,
            PackagesTableSeeder::class,
            RegistrationsTableSeeder::class,
            LessonsTableSeeder::class,
            PickupAddressesTableSeeder::class,
            PickupAddressesPerLessonTableSeeder::class,
            ExamsTableSeeder::class,
            InvoicesTableSeeder::class,
            PaymentsTableSeeder::class,
        ]);
    }
}
