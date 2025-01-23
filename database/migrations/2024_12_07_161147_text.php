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
        Schema::create('text', function (Blueprint $table) {
            $table->id();
            $table->text('text')->nullable();
            $table->foreignid('theme_id')->nullable()
                ->references('id')->on('theme')->onDelete('cascade');
            $table->integer('position')->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('text_media', function (Blueprint $table) {
            $table->id();
            $table->foreignid('text_id')->nullable()
                ->references('id')->on('text')->onDelete('cascade');
            $table->foreignid('media_id')->nullable()
                ->references('id')->on('text')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('text_media');
        Schema::dropIfExists('text');
    }
};
