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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name')->nullable();
        });
        Schema::create('user_group', function (Blueprint $table) {
            $table->id();
            $table->foreignid('user_id')->nullable()
                ->references('id')->on('users')->onDelete('cascade');
            $table->foreignid('group_id')->nullable()
                ->references('id')->on('groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_group');
        Schema::dropIfExists('group');
    }
};
