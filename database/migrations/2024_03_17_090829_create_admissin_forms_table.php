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
        Schema::create('admissin_forms', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('name');
            $table->string('age');
            $table->string('father_or_husb_name');
            $table->string('mother_name');
            $table->string('permanent_address');
            $table->string('pa_village');
            $table->string('pa_post_code');
            $table->string('pa_thana');
            $table->string('pa_district');
            $table->string('present_address');
            $table->string('pre_village');
            $table->string('pre_post_code');
            $table->string('pre_thana');
            $table->string('pre_district');
            $table->string('mobile');
            $table->string('admission_date');
            $table->string('admission_time');
            $table->string('disease_name')->nullable();
            $table->string('doctor_name');
            $table->string('cabin_no');
            $table->string('date_of_leave')->nullable();
            $table->string('leave_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissin_forms');
    }
};
