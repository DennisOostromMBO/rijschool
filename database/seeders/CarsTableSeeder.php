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
            [
                'brand' => 'Tesla',
                'type' => 'Model 3',
                'license_plate' => 'EF-456-GH',
                'fuel' => 'Electric',
                'is_active' => true,
                'remark' => 'Secondary car',
                'created_at' => now(),
                'updated_at' => now(),
            ],
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
            
        ]);
    }
}
