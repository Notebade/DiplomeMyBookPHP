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
        Schema::create('rights', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name')->nullable();
        });
        Schema::create('user_right', function (Blueprint $table) {
            $table->id();
            $table->foreignid('user_id')->nullable()
                ->references('id')->on('users')->onDelete('cascade');
            $table->foreignid('right_id')->nullable()
                ->references('id')->on('rights')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_right');
        Schema::dropIfExists('rights');
    }
};
