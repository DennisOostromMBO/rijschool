<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payments')->insert([
            [
                'invoice_id' => 1,
                'date' => now(),
                'status' => 'Completed',
                'is_active' => true,
                'remark' => 'Full payment received',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'invoice_id' => 2,
                'date' => now()->subDays(5),
                'status' => 'Pending',
                'is_active' => true,
                'remark' => 'Partial payment pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
