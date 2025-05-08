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
            // ...add more pickup addresses as needed...
        ]);
    }
}
