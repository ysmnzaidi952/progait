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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('patientName');
            $table->string('patientIC', 12);
            $table->string('patientTel');
            $table->date('appointmentDate');
            $table->time('appointmentTime');
            $table->enum('status', ['upcoming', 'completed', 'cancelled'])->default('upcoming');
            $table->text('cancelReason')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
