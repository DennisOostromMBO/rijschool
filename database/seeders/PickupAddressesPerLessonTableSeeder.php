<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PickupAddressesPerLessonTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pickup_addresses_per_lesson')->insert([
            [
                'lesson_id' => 1,
                'pickup_address_id' => 1,
                'is_active' => true,
                'remark' => 'Primary pickup address for lesson',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lesson_id' => 1,
                'pickup_address_id' => 2,
                'is_active' => true,
                'remark' => 'Secondary pickup address for lesson',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // ...add more records as needed...
        ]);
    }
}
