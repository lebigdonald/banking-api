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
            "DROP PROCEDURE IF EXISTS createTransaction;
            CREATE PROCEDURE createTransaction (account_id_from BIGINT, account_id_to BIGINT, amount DECIMAL(65,2))

            BEGIN
                INSERT INTO transactions (`account_id`, `debit_amount`, `created_at`, `updated_at`)
                VALUES (account_id_from, amount, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

                UPDATE accounts SET `balance` = GREATEST(0, balance - amount), `updated_at` = CURRENT_TIMESTAMP
                WHERE id = account_id_from;

                INSERT INTO transactions (`account_id`, `credit_amount`, `created_at`, `updated_at`)
                VALUES (account_id_to, amount, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

                UPDATE accounts SET `balance` = (balance + amount), `updated_at` = CURRENT_TIMESTAMP
                WHERE id = account_id_to;
            END;"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS createTransaction;");
    }
};
