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
        Schema::create('journals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->date('date');
            $table->string('title', 100)->nullable();
            $table->text('content');
            $table->enum('mood', ['happy', 'sad', 'anxious', 'calm', 'angry', 'confused', 'excited', 'tired', 'satisfied', 'frustrated'])->default('calm');
            $table->json('tags')->nullable();
            $table->enum('category', ['Personal', 'Social', 'Career', 'Spiritual', 'Academic', 'Health', 'Finance', 'Hobby'])->default('Personal');
            $table->boolean('important')->default(false);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            
            // MySQL specific indexes
            $table->index(['user_id', 'date']);
            $table->index(['user_id', 'mood']);
            $table->index(['user_id', 'category']);
            $table->index(['user_id', 'important']);
            $table->index(['date']);
            // JSON index for tags (MySQL 5.7+)
            $table->index(['user_id'], 'journals_user_id_tags_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
