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
            "DROP PROCEDURE IF EXISTS getAccountBalance;
            CREATE PROCEDURE getAccountBalance (_id BIGINT)

            BEGIN
                SELECT balance FROM accounts WHERE `id` = _id;
            END;"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS getAccountBalance;");
    }
};
