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
        Schema::table('messages', function (Blueprint $table) {
            // Drop existing foreign keys
            $table->dropForeign(['user_id']);
            $table->dropForeign(['discuss_id']);
            $table->dropForeign(['agent_id']);

            // Re-add foreign keys with cascade delete
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('discuss_id')->references('id')->on('discusses')->onDelete('cascade');
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Drop cascade foreign keys
            $table->dropForeign(['user_id']);
            $table->dropForeign(['discuss_id']);
            $table->dropForeign(['agent_id']);

            // Re-add original foreign keys without cascade
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('discuss_id')->references('id')->on('discusses');
            $table->foreign('agent_id')->references('id')->on('agents');
        });
    }
};
