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
            // ...add more records as needed...
        ]);
    }
}
