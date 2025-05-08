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
                'email' => 'contact@example.com',
                'is_active' => true,
                'remark' => 'Primary contact',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // ...add more contacts as needed...
        ]);
    }
}
