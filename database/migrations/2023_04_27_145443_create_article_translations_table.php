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
        Schema::create('article_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->string('title', 255)->index();
            $table->text('text');
            $table->enum('language_code', ['en', 'ar', 'ja']);
            $table->timestamps();
            $table->unique(['title', 'language_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_translations');
    }
};
