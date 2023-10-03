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
            "DROP PROCEDURE IF EXISTS updateAPIToken;
            CREATE PROCEDURE updateAPIToken (_email VARCHAR(64), _api_token VARCHAR(80))

            BEGIN
                UPDATE users SET `api_token` = _api_token, `updated_at` = CURRENT_TIMESTAMP WHERE email = _email;

                SELECT * FROM users WHERE `email` = _email;
            END;"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS updateAPIToken;");
    }
};
