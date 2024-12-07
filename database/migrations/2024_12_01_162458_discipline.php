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
        Schema::create('disciplines', function (Blueprint $table) {
           $table->id();
           $table->string('code')->unique();
           $table->string('name');
           $table->string('description')->nullable();
           $table->foreignid('media_id')->nullable()
                ->references('id')->on('media_files')->onDelete('cascade');
           $table->foreignid('user_id')->nullable()
                ->references('id')->on('users')->onDelete('cascade');
           $table->timestamps();
           $table->softDeletes();
        });

        Schema::create('author_discipline', function (Blueprint $table) {
            $table->id();
            $table->foreignid('discipline_id')->nullable()
                ->references('id')->on('disciplines')->onDelete('cascade');
            $table->foreignid('user_id')->nullable()
                ->references('id')->on('users')->onDelete('cascade');
        });

        //todo переход на множество картинок (возможность)

        Schema::create('media_discipline_type', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
        });

        Schema::create('media_discipline', function (Blueprint $table) {
            $table->id();
            $table->foreignid('discipline_id')->nullable()
                ->references('id')->on('disciplines')->onDelete('cascade');
            $table->foreignid('media_id')->nullable()
                ->references('id')->on('media_files')->onDelete('cascade');
            $table->foreignid('media_type_id')->nullable()
                ->references('id')->on('media_discipline_type')->onDelete('cascade');
            $table->softDeletes();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('author_discipline');
        Schema::dropIfExists('media_discipline_type');
        Schema::dropIfExists('media_discipline');
        Schema::dropIfExists('disciplines');
    }
};
