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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('type_message');
            // $table->foreignId('id_user')->constrained();
            // $table->foreignId('id_discuss')->constrained();
            // $table->foreignId('id_agent')->constrained();
            $table->integer('id_user');
            $table->integer('id_discuss');
            $table->integer('id_agent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
