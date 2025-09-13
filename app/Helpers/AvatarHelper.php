<?php

namespace App\Helpers;

class AvatarHelper
{
    /**
     * Get avatar URL for user
     *
     * @param string|null $avatarPath
     * @return string|null
     */
    public static function getAvatarUrl(?string $avatarPath): ?string
    {
        if (!$avatarPath) {
            return null;
        }

        // If it's already a full URL, return as is
        if (filter_var($avatarPath, FILTER_VALIDATE_URL)) {
            return $avatarPath;
        }

        // If it's a relative path, make it absolute
        if (str_starts_with($avatarPath, 'uploads/')) {
            return asset($avatarPath);
        }

        // For backward compatibility with old storage paths
        if (str_starts_with($avatarPath, 'avatars/')) {
            return asset('uploads/' . $avatarPath);
        }

        return asset($avatarPath);
    }

    /**
     * Get default avatar (user initial)
     *
     * @param string $name
     * @return string
     */
    public static function getDefaultAvatar(string $name): string
    {
        return strtoupper(substr($name, 0, 1));
    }

    /**
     * Check if avatar exists
     *
     * @param string|null $avatarPath
     * @return bool
     */
    public static function avatarExists(?string $avatarPath): bool
    {
        if (!$avatarPath) {
            return false;
        }

        // If it's a relative path, check in public directory
        if (str_starts_with($avatarPath, 'uploads/')) {
            return file_exists(public_path($avatarPath));
        }

        // For backward compatibility with old storage paths
        if (str_starts_with($avatarPath, 'avatars/')) {
            return file_exists(public_path('uploads/' . $avatarPath));
        }

        return file_exists(public_path($avatarPath));
    }

    /**
     * Delete avatar file
     *
     * @param string|null $avatarPath
     * @return bool
     */
    public static function deleteAvatar(?string $avatarPath): bool
    {
        if (!$avatarPath) {
            return false;
        }

        // If it's a relative path, delete from public directory
        if (str_starts_with($avatarPath, 'uploads/')) {
            $filePath = public_path($avatarPath);
        } elseif (str_starts_with($avatarPath, 'avatars/')) {
            // For backward compatibility with old storage paths
            $filePath = public_path('uploads/' . $avatarPath);
        } else {
            $filePath = public_path($avatarPath);
        }

        if (file_exists($filePath)) {
            return unlink($filePath);
        }

        return false;
    }
}
