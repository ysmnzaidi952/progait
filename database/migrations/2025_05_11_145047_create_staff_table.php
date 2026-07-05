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
    Schema::create('staff', function (Blueprint $table) {
        $table->string('staffID')->primary();  // Change to string and set it as primary key
        $table->string('staffName');
        $table->string('staffIC');
        $table->string('staffEmail')->unique();
        $table->string('staffPass');
        $table->string('staffTel');
        $table->string('staffRole'); // 'admin' or 'staff'
        $table->timestamps();
    });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
