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
                'remark' => 'Test user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // ...add more users as needed...
        ]);
    }
}
