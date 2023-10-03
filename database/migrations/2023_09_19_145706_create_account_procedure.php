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
            "DROP PROCEDURE IF EXISTS createAccount;
            CREATE PROCEDURE createAccount (_account_number BIGINT, _customer_id BIGINT, initial_amount DECIMAL(65,2))

            BEGIN
                INSERT INTO accounts (`account_number`, `customer_id`, `balance`, `created_at`, `updated_at`)
                VALUES (_account_number, _customer_id, initial_amount, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

                SELECT * FROM accounts ORDER BY id DESC LIMIT 1;
            END;"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS createAccount;");
    }
};
