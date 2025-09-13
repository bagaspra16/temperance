<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Helpers\AvatarHelper;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $achievements = $user->achievements()->latest()->take(5)->get();
        
        return view('profile.index', compact('user', 'achievements'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'bio' => ['nullable', 'string', 'max:500'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'remove_avatar' => ['nullable', 'boolean'],
        ]);

        try {
            // Update basic information
            $user->name = $request->name;
            $user->email = $request->email;
            $user->bio = $request->bio;

            // Handle avatar upload or removal
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                AvatarHelper::deleteAvatar($user->avatar);
                
                // Create uploads/avatars directory if it doesn't exist
                $uploadPath = public_path('uploads/avatars');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Generate unique filename
                $file = $request->file('avatar');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                
                // Move file to public/uploads/avatars
                $file->move($uploadPath, $filename);
                
                // Store relative path in database
                $user->avatar = 'uploads/avatars/' . $filename;
            } elseif ($request->input('remove_avatar') == '1') {
                // Remove avatar if requested
                AvatarHelper::deleteAvatar($user->avatar);
                $user->avatar = null;
            }

            $user->save();

            return redirect()->route('profile.index')
                ->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update profile. Please try again.')
                ->withInput();
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        // Logout user after password change
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Password changed successfully! Please login with your new password.');
    }
} 