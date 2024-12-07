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
        //todo да похоже на таблицу с discipline можно было просто parent_id, но пока лучше так сделать есть наитие
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->foreignid('media_id')->nullable()
                ->references('id')->on('media_files')->onDelete('cascade');
            $table->foreignid('user_id')->nullable()
                ->references('id')->on('users')->onDelete('cascade');
            $table->foreignid('discipline_id')->nullable()
                ->references('id')->on('disciplines')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
