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
