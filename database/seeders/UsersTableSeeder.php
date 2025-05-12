<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'first_name' => 'John',
                'middle_name' => 'van',
                'last_name' => 'Doe',
                'birth_date' => '1990-01-01',
                'username' => 'johndoe',
                'password' => Hash::make('password123'),
                'is_logged_in' => false,
                'logged_in_at' => null,
                'logged_out_at' => null,
                'is_active' => true,
                'remark' => 'Test user 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Jane',
                'middle_name' => null,
                'last_name' => 'Smith',
                'birth_date' => '1995-05-15',
                'username' => 'janesmith',
                'password' => Hash::make('password123'),
                'is_logged_in' => false,
                'logged_in_at' => null,
                'logged_out_at' => null,
                'is_active' => true,
                'remark' => 'Test user 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Alice',
                'middle_name' => null,
                'last_name' => 'Johnson',
                'birth_date' => '2000-09-10',
                'username' => 'alicejohnson',
                'password' => Hash::make('studentpass'),
                'is_logged_in' => false,
                'logged_in_at' => null,
                'logged_out_at' => null,
                'is_active' => true,
                'remark' => 'Student user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
