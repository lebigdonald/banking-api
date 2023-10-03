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
            "DROP PROCEDURE IF EXISTS getAccountHistory;
            CREATE PROCEDURE getAccountHistory (_account_id BIGINT)

            BEGIN
                SELECT * FROM transactions WHERE `account_id` = _account_id ORDER BY created_at ASC;
            END;"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS getAccountHistory;");
    }
};
