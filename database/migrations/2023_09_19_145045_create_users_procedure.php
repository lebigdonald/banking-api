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
            "DROP PROCEDURE IF EXISTS createUser;
            CREATE PROCEDURE createUser (_name TEXT, _email VARCHAR(64), _password TEXT)

            BEGIN
                INSERT INTO users (`name`, `email`, `password`, `created_at`, `updated_at`)
                VALUES (_name, _email, _password, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

                SELECT * FROM users WHERE `email` = _email;
            END;"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS createUser;");
    }
};
