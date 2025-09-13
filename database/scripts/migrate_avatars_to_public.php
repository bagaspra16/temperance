<?php

/**
 * Script untuk migrasi avatar dari storage ke public
 * 
 * Usage: php database/scripts/migrate_avatars_to_public.php
 */

require_once __DIR__ . '/../../../vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AvatarMigrator
{
    public function migrateAvatars()
    {
        echo "Starting avatar migration from storage to public...\n";
        
        // Get all users with avatars
        $users = DB::table('users')->whereNotNull('avatar')->get();
        
        $migrated = 0;
        $skipped = 0;
        $errors = 0;
        
        foreach ($users as $user) {
            try {
                $oldPath = $user->avatar;
                
                // Skip if already in public directory
                if (str_starts_with($oldPath, 'uploads/')) {
                    echo "Skipping {$user->name}: Already in public directory\n";
                    $skipped++;
                    continue;
                }
                
                // Check if file exists in storage
                if (!Storage::disk('public')->exists($oldPath)) {
                    echo "Warning: File not found for {$user->name}: {$oldPath}\n";
                    $errors++;
                    continue;
                }
                
                // Create uploads/avatars directory if it doesn't exist
                $uploadPath = public_path('uploads/avatars');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Generate new filename
                $extension = pathinfo($oldPath, PATHINFO_EXTENSION);
                $newFilename = uniqid() . '_' . $user->id . '.' . $extension;
                $newPath = 'uploads/avatars/' . $newFilename;
                
                // Copy file from storage to public
                $fileContent = Storage::disk('public')->get($oldPath);
                file_put_contents(public_path($newPath), $fileContent);
                
                // Update database
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['avatar' => $newPath]);
                
                // Delete old file from storage
                Storage::disk('public')->delete($oldPath);
                
                echo "Migrated {$user->name}: {$oldPath} -> {$newPath}\n";
                $migrated++;
                
            } catch (Exception $e) {
                echo "Error migrating {$user->name}: " . $e->getMessage() . "\n";
                $errors++;
            }
        }
        
        echo "\nMigration completed!\n";
        echo "Migrated: {$migrated}\n";
        echo "Skipped: {$skipped}\n";
        echo "Errors: {$errors}\n";
    }
    
    public function verifyMigration()
    {
        echo "Verifying avatar migration...\n";
        
        $users = DB::table('users')->whereNotNull('avatar')->get();
        
        $valid = 0;
        $invalid = 0;
        
        foreach ($users as $user) {
            $avatarPath = $user->avatar;
            
            if (str_starts_with($avatarPath, 'uploads/')) {
                $fullPath = public_path($avatarPath);
                if (file_exists($fullPath)) {
                    echo "✓ {$user->name}: {$avatarPath}\n";
                    $valid++;
                } else {
                    echo "✗ {$user->name}: File not found - {$avatarPath}\n";
                    $invalid++;
                }
            } else {
                echo "✗ {$user->name}: Invalid path format - {$avatarPath}\n";
                $invalid++;
            }
        }
        
        echo "\nVerification completed!\n";
        echo "Valid: {$valid}\n";
        echo "Invalid: {$invalid}\n";
    }
}

// Run migration if called directly
if (php_sapi_name() === 'cli') {
    $migrator = new AvatarMigrator();
    
    if (isset($argv[1]) && $argv[1] === 'verify') {
        $migrator->verifyMigration();
    } else {
        $migrator->migrateAvatars();
    }
}
