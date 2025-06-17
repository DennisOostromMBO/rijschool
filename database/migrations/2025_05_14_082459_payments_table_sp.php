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
        $spFiles = [
            database_path('sp/daniel/sp_get_payments.sql'),
            database_path('sp/daniel/sp_create_payment.sql'),
            database_path('sp/daniel/sp_update_payment.sql'),
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
        DB::unprepared('DROP PROCEDURE IF EXISTS GetPayments');
        DB::unprepared('DROP PROCEDURE IF EXISTS CreatePayment');
        DB::unprepared('DROP PROCEDURE IF EXISTS UpdatePayment');
    }
};
