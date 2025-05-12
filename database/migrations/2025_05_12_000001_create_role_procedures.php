<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Stored procedure om een rol aan een user te koppelen
        DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_assign_role_to_user;
            CREATE PROCEDURE sp_assign_role_to_user(IN p_user_id BIGINT, IN p_role_name VARCHAR(255), IN p_remark TEXT)
            BEGIN
                INSERT INTO roles (user_id, name, is_active, remark, created_at, updated_at)
                VALUES (p_user_id, p_role_name, true, p_remark, NOW(), NOW());
            END;
        ');

        // Stored procedure om overzicht van users met hun rollen op te halen
        DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_get_users_with_roles;
            CREATE PROCEDURE sp_get_users_with_roles()
            BEGIN
                SELECT users.id AS user_id, users.name AS user_name, roles.name AS role_name, roles.is_active, roles.remark
                FROM users
                JOIN roles ON users.id = roles.user_id;
            END;
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_assign_role_to_user;');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_get_users_with_roles;');
    }
};
