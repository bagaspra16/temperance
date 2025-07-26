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
        Schema::create('achievements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('goal_id');
            $table->string('title');
            $table->text('description');
            $table->text('certificate_message'); // Pesan dari AI
            $table->text('affirmation_message'); // Kata-kata afirmasi dari AI
            $table->string('certificate_number')->unique(); // Nomor sertifikat unik
            $table->date('achievement_date');
            $table->string('status')->default('active'); // active, archived
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('goal_id')->references('id')->on('goals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
