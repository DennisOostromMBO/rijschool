<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    public function up(): void
    {
        // Drop the stored procedures if they exist
        DB::unprepared('DROP PROCEDURE IF EXISTS SPGetAllStudents');
        DB::unprepared('DROP PROCEDURE IF EXISTS SPGetAllInstructors');
        DB::unprepared('DROP PROCEDURE IF EXISTS SPCreateInstructeur');

        // Load the stored procedures from the SQL files
        $studentPath = database_path('SP/dennis/students/SPGetAllStudents.sql');
        DB::unprepared(File::get($studentPath));

        $instructorPath = database_path('SP/dennis/instructors/SPGetAllInstructors.sql');
        DB::unprepared(File::get($instructorPath));

        $createInstructorPath = database_path('SP/dennis/instructors/SPCreateInstructeur.sql');
        DB::unprepared(File::get($createInstructorPath));
    }

    public function down(): void
    {
        // Drop the stored procedures
        DB::unprepared('DROP PROCEDURE IF EXISTS SPGetAllStudents');
        DB::unprepared('DROP PROCEDURE IF EXISTS SPGetAllInstructors');
        DB::unprepared('DROP PROCEDURE IF EXISTS SPCreateInstructeur');
    }
};
