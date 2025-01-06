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
        Schema::create('test', function (Blueprint $table) {
            $table->id();
            $table->foreignid('theme_id')->nullable()
                ->references('id')->on('theme')->onDelete('cascade');
            $table->foreignid('user_id')->nullable()
                ->references('id')->on('users')->onDelete('cascade');
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('question_type', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->foreignid('type_id')->nullable()
                ->references('id')->on('question_type')->onDelete('cascade');
            $table->foreignid('test_id')->nullable()
                ->references('id')->on('test')->onDelete('cascade');
        });

        Schema::create('media_question', function (Blueprint $table) {
            $table->id();
            $table->foreignid('question_id')->nullable()
                ->references('id')->on('questions')->onDelete('cascade');
            $table->foreignid('media_id')->nullable()
                ->references('id')->on('media_files')->onDelete('cascade');
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignid('question_id')->nullable()
                ->references('id')->on('questions')->onDelete('cascade');
            $table->string('text');
            $table->boolean('right')->default(false);
        });

        Schema::create('user_answer_type', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
        });


        Schema::create('user_test', function (Blueprint $table) {
            $table->id();
            $table->foreignid('type_id')->nullable()
                ->references('id')->on('user_answer_type')->onDelete('cascade');
            $table->foreignid('test_id')->nullable()
                ->references('id')->on('test')->onDelete('cascade');
            $table->integer('trail')->default(0);
            $table->float('score')->default(0);
        });

        Schema::create('answer_user_test', function (Blueprint $table) {
            $table->id();
            $table->foreignid('user_test_id')->nullable()
                ->references('id')->on('user_test')->onDelete('cascade');
            $table->foreignid('answers_id')->nullable()
                ->references('id')->on('answers')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test');
    }
};
