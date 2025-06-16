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
        // Load the stored procedure SQL from the file
        $path = database_path('sp/daniel/sp_get_invoices.sql');
        $path = database_path('sp/daniel/sp_create_invoices.sql');
        $path = database_path('sp/daniel/sp_update_invoice.sql');
        $sql = file_get_contents($path);

        // Execute the SQL to create the stored procedure
        DB::unprepared($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the stored procedure if it exists
        DB::unprepared('DROP PROCEDURE IF EXISTS GetInvoices');
        DB::unprepared('DROP PROCEDURE IF EXISTS CreateInvoices');
        DB::unprepared('DROP PROCEDURE IF EXISTS UpdateInvoices');
    }
};
