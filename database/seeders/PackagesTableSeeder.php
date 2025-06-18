<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackagesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('packages')->insert([
            [
                'type' => 'Package1',
                'lesson_count' => 10,
                'price_per_lesson' => 50.00,
                'is_active' => true,
                'remark' => 'Basic package',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Package2',
                'lesson_count' => 20,
                'price_per_lesson' => 45.00,
                'is_active' => true,
                'remark' => 'Advanced package',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Package2',
                'lesson_count' => 20,
                'price_per_lesson' => 45.00,
                'is_active' => true,
                'remark' => 'Advanced package',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
