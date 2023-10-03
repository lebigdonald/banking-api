<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->enum('gender', ['M', 'F', 'O'])->default('M');
            $table->string('email', 64)->unique();
            $table->string('phone_number', 20)->unique();
            $table->date('date_of_birth')->nullable();
            $table->text('place_of_birth')->nullable();
            $table->enum('status', ['M', 'S', 'D', 'W', 'O'])->default('M');
            $table->text('profession')->nullable();
            $table->enum('identification_type', ['ID', 'P'])->default('ID');
            $table->date('issue_date')->nullable();
            $table->text('issue_place')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
