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
        Schema::create('cash_memo_infos', function (Blueprint $table) {
            $table->id();
            $table->string('patient_uuid');
            $table->string('patient_name');
            $table->string('admission_date');
            $table->string('leave_date');
            $table->string('address');
            $table->string('mobile');
            $table->string('cabin_no');
            $table->string('regi_no');
            $table->string('total_bill');
            $table->string('discount');
            $table->string('total_paid');
            $table->string('paid');
            $table->string('outstanding_total');
            $table->string('generated_by');
            $table->timestamps();
        });
    }

    // admission_date
    // leave_date
    // name
    // phone
    // cabin_no
    // regi_no
    // total_amount
    // discount
    // total_paid



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_memo_infos');
    }
};
