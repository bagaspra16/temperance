<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing avatar paths from storage to public
        DB::table('users')
            ->whereNotNull('avatar')
            ->where('avatar', 'like', 'avatars/%')
            ->update([
                'avatar' => DB::raw("CONCAT('uploads/', avatar)")
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert avatar paths back to storage format
        DB::table('users')
            ->whereNotNull('avatar')
            ->where('avatar', 'like', 'uploads/avatars/%')
            ->update([
                'avatar' => DB::raw("SUBSTRING(avatar, 9)") // Remove 'uploads/' prefix
            ]);
    }
};