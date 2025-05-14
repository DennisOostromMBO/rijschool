<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         // Load the stored procedure SQL from the file
        $path = database_path('sp/daniel/sp_get_payments.sql');
        $sql = file_get_contents($path);

        // Execute the SQL to create the stored procedure
        DB::unprepared($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
