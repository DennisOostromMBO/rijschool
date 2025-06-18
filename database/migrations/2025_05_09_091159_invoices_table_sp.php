<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Load and execute all stored procedure SQL files
        $spFiles = [
            database_path('sp/daniel/sp_get_invoices.sql'),
            database_path('sp/daniel/sp_create_invoices.sql'),
            database_path('sp/daniel/sp_update_invoice.sql'),
        ];
        foreach ($spFiles as $path) {
            if (file_exists($path)) {
                $sql = file_get_contents($path);
                DB::unprepared($sql);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GetInvoices');
        DB::unprepared('DROP PROCEDURE IF EXISTS CreateInvoice');
        DB::unprepared('DROP PROCEDURE IF EXISTS UpdateInvoice');
    }
};
