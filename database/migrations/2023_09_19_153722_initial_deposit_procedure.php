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
            "DROP PROCEDURE IF EXISTS initialDeposit;
            CREATE PROCEDURE initialDeposit (_account_id BIGINT, _initial_amount DECIMAL(65,2))

            BEGIN
                INSERT INTO transactions (`account_id`, `credit_amount`, `created_at`, `updated_at`)
                VALUES (_account_id, _initial_amount, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
            END;"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS initialDeposit;");
    }
};
