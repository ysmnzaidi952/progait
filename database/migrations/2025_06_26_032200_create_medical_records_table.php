<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->string('status');
            $table->string('assigned_doctor')->nullable();
            $table->string('amputation_level');
            $table->string('amputation_side');
            $table->date('amputation_date')->nullable();
            $table->string('amputation_cause')->nullable();
            $table->float('weight_kg')->nullable();
            $table->float('height_cm')->nullable();
            $table->float('bmi')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->integer('heart_rate')->nullable();
            $table->float('blood_sugar_level')->nullable();
            $table->string('mobility_aid_used')->nullable();
            $table->date('next_checkup_date')->nullable();
            $table->text('rehabilitation_status')->nullable();
            $table->text('treatment_notes')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')->references('patientID')->on('patient')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
