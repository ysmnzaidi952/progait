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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id(); // primary key
            $table->string('patientName');
            $table->string('patientIC');
            $table->string('race')->nullable();
            $table->string('gender');
            $table->text('address');
            $table->string('sponsor')->nullable();
            $table->string('hospital')->nullable();
            $table->float('weight')->nullable();
            $table->string('footSize')->nullable();
            $table->string('linerSize')->nullable();
            $table->date('amputationDate')->nullable();
            $table->string('prosthesisNo')->nullable();
            $table->string('patientTel');
            $table->string('patientTel2')->nullable();
            $table->string('reasonAmputation')->nullable();
            $table->text('patientAssessment')->nullable();
            $table->string('dialysisDay')->nullable(); // we'll store as JSON or comma-separated string
            $table->text('componentSuggestions')->nullable();
            $table->string('attendedBy');
            $table->string('prescribedBy');
            $table->date('receiveDate')->nullable();
            $table->timestamps(); // includes created_at and updated_at
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
