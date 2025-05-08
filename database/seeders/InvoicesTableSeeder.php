<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoicesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('invoices')->insert([
            [
                'registration_id' => 1,
                'invoice_number' => 'INV-0001',
                'invoice_date' => now(),
                'amount_excl_vat' => 500.00,
                'vat' => 21.00,
                'amount_incl_vat' => 605.00,
                'invoice_status' => 'Paid',
                'is_active' => true,
                'remark' => 'First invoice',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'registration_id' => 2,
                'invoice_number' => 'INV-0002',
                'invoice_date' => now()->subDays(10),
                'amount_excl_vat' => 1000.00,
                'vat' => 21.00,
                'amount_incl_vat' => 1210.00,
                'invoice_status' => 'Pending',
                'is_active' => true,
                'remark' => 'Second invoice',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
