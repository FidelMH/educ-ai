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
        Schema::create('has', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Foreign
            $table->foreignId('level_id')->constrained(); //Foreign
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('has');
    }
};
