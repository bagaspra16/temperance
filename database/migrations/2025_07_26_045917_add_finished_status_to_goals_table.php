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
        Schema::table('goals', function (Blueprint $table) {
            // Drop the existing enum constraint
            $table->dropColumn('status');
        });

        Schema::table('goals', function (Blueprint $table) {
            // Recreate the enum with 'finished' status
            $table->enum('status', ['not_started', 'in_progress', 'completed', 'finished', 'abandoned'])->default('not_started')->after('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('goals', function (Blueprint $table) {
            // Drop the new enum constraint
            $table->dropColumn('status');
        });

        Schema::table('goals', function (Blueprint $table) {
            // Recreate the original enum without 'finished'
            $table->enum('status', ['not_started', 'in_progress', 'completed', 'abandoned'])->default('not_started')->after('priority');
        });
    }
};
