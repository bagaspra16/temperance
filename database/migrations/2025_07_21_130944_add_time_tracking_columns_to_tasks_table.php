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
        Schema::table('tasks', function (Blueprint $table) {
            $table->dateTime('start_time')->nullable()->after('status');
            $table->dateTime('completed_time')->nullable()->after('start_time');
            $table->integer('duration_minutes')->nullable()->after('completed_time');
            $table->text('force_complete_reason')->nullable()->after('duration_minutes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn([
                'start_time',
                'completed_time', 
                'duration_minutes',
                'force_complete_reason'
            ]);
        });
    }
};
