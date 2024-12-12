<?php
declare(strict_types=1);

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
        Schema::create('media_files', static function (Blueprint $table) {
            $table->id();
            $table->foreignid('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->string('path');
            $table->string('type')->nullable();
            $table->timestamps();
            $table->foreignid('parent_id')->nullable()
                ->references('id')->on('media_files')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_files');
    }
};
