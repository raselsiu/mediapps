<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registraton_forms', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->integer('serial_no')->unique();
            $table->string('name');
            $table->string('is_admitted')->default(false);
            $table->string('is_payment_clear')->default(false);
            $table->string('status')->default(0);
            $table->string('address');
            $table->string('cabin_no')->nullable();
            $table->string('regi_no')->nullable();
            $table->string('regi_fee');
            $table->string('generated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registraton_forms');
    }
};
