<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('contacts')->insert([
            [
                'user_id' => 1,
                'street_name' => 'Main Street',
                'house_number' => '123',
                'addition' => 'A',
                'postal_code' => '1234AB',
                'city' => 'Amsterdam',
                'mobile' => '0612345678',
                'email' => 'contact1@example.com',
                'is_active' => true,
                'remark' => 'Primary contact',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'street_name' => 'Second Avenue',
                'house_number' => '456',
                'addition' => null,
                'postal_code' => '5678CD',
                'city' => 'Rotterdam',
                'mobile' => '0687654321',
                'email' => 'contact2@example.com',
                'is_active' => true,
                'remark' => 'Secondary contact',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'street_name' => 'Hoofdstraat',
                'house_number' => '10',
                'addition' => null,
                'postal_code' => '1234AB',
                'city' => 'Amsterdam',
                'mobile' => '0612345678',
                'email' => 'jane.smith@example.com',
                'is_active' => true,
                'remark' => 'Contact voor Jane Smith',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'street_name' => 'Dorpsweg',
                'house_number' => '22',
                'addition' => 'A',
                'postal_code' => '5678CD',
                'city' => 'Rotterdam',
                'mobile' => '0687654321',
                'email' => 'piet.vliet@example.com',
                'is_active' => true,
                'remark' => 'Contact voor Piet van Vliet',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
