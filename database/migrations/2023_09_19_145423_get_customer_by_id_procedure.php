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
            "DROP PROCEDURE IF EXISTS getCustomerByID;
            CREATE PROCEDURE getCustomerByID (_id BIGINT)

            BEGIN
                SELECT * FROM customers WHERE `id` = _id;
            END;"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS getCustomerByID;");
    }
};
