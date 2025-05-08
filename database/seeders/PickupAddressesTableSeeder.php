<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PickupAddressesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pickup_addresses')->insert([
            [
                'street_name' => 'Elm Street',
                'house_number' => '456',
                'addition' => 'B',
                'postal_code' => '5678CD',
                'city' => 'Rotterdam',
                'is_active' => true,
                'remark' => 'Secondary pickup location',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'street_name' => 'Oak Avenue',
                'house_number' => '789',
                'addition' => null,
                'postal_code' => '1234EF',
                'city' => 'Amsterdam',
                'is_active' => true,
                'remark' => 'Primary pickup location',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
