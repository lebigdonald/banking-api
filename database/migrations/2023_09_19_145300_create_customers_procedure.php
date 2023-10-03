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
            "DROP PROCEDURE IF EXISTS createCustomer;
            CREATE PROCEDURE createCustomer (_name TEXT, _gender ENUM('M','F','O'), _email VARCHAR(64),
            _phone_number VARCHAR(20), _date_of_birth DATE, _place_of_birth TEXT, _status ENUM('M','S','D','W','O'),
            _profession TEXT, _identification_type ENUM('ID', 'P'), _issue_date DATE, _issue_place TEXT)

            BEGIN
                INSERT INTO customers (`name`, `gender`, `email`, `phone_number`, `date_of_birth`, `place_of_birth`,
                `status`, `profession`, `identification_type`, `issue_date`, `issue_place`, `created_at`, `updated_at`)
                VALUES (_name, _gender, _email, _phone_number, _date_of_birth, _place_of_birth, _status, _profession,
                _identification_type, _issue_date, _issue_place, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

                SELECT * FROM customers ORDER BY id DESC LIMIT 1;
            END;"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS createCustomer;");
    }
};
