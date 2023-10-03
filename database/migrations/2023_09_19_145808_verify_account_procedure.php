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
            "DROP PROCEDURE IF EXISTS verifyAccount;
            CREATE PROCEDURE verifyAccount (_account_number BIGINT, _customer_id BIGINT)

            BEGIN
                SELECT * FROM accounts WHERE (`account_number` = _account_number AND `customer_id` = _customer_id);
            END;"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS verifyAccount;");
    }
};
