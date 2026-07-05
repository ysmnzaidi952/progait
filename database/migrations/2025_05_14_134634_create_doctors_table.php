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
        Schema::create('doctors', function (Blueprint $table) {
            $table->string('docID')->primary(); // Custom ID, no auto-increment
            $table->string('docIC')->unique();
            $table->string('docName');
            $table->string('docEmail')->unique();
            $table->string('docPass');
            $table->string('docTel');
            $table->enum('status', ['pending', 'approved'])->default('pending'); // Approval status
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
