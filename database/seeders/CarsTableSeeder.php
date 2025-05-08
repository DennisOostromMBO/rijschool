<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('cars')->insert([
            [
                'brand' => 'Toyota',
                'type' => 'Corolla',
                'license_plate' => 'AB-123-CD',
                'fuel' => 'Gasoline',
                'is_active' => true,
                'remark' => 'Primary car',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // ...add more cars as needed...
        ]);
    }
}
