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
        Schema::table('medical_records', function (Blueprint $table) {
            $table->string('k_level')->nullable();
            $table->string('health_condition')->nullable();
            $table->integer('blart_score')->nullable();
        });
    }

    public function down()
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropColumn(['k_level', 'health_condition', 'blart_score']);
        });
    }

};
