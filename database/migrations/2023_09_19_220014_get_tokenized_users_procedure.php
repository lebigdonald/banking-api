<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared(
            "DROP PROCEDURE IF EXISTS getTokenizedUsers;
            CREATE PROCEDURE getTokenizedUsers ()

            BEGIN
                SELECT * FROM users WHERE `api_token` IS NOT NULL ORDER BY updated_at ASC;
            END;"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS getTokenizedUsers;");
    }
};
