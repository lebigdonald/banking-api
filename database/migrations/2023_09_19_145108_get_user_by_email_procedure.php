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
            "DROP PROCEDURE IF EXISTS getUserByEmail;
            CREATE PROCEDURE getUserByEmail (_email VARCHAR(64))

            BEGIN
                SELECT * FROM users WHERE email = _email;
            END;"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS getUserByEmail;");
    }
};
