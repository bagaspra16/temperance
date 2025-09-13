@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-6 sm:mb-8">
            <div class="flex items-center justify-between profile-header">
                <div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow mb-2">Profile Settings</h1>
                    <p class="text-gray-400 text-base sm:text-lg">Manage your profile information and account</p>
                </div>
                <div class="hidden sm:block">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-gradient-to-br from-pink-500 to-pink-700 flex items-center justify-center shadow-lg">
                        <i class="fas fa-user-cog text-white text-lg sm:text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
            <!-- Profile Information Card -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Profile Overview Card -->
                <div class="bg-gray-800/50 backdrop-blur-xl rounded-2xl border border-gray-700/50 p-4 sm:p-6 lg:p-8 profile-card">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-6 mb-6 sm:mb-8 profile-avatar-section">
                        <div class="relative">
                            <div class="w-20 h-20 sm:w-24 sm:h-24 lg:w-32 lg:h-32 rounded-full bg-gradient-to-br from-pink-500 to-pink-700 flex items-center justify-center shadow-2xl overflow-hidden profile-avatar-large">
                                @if($user->avatar)
                                    <img src="{{ \App\Helpers\AvatarHelper::getAvatarUrl($user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    <span class="text-white text-2xl sm:text-3xl lg:text-4xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div class="absolute -bottom-2 -right-2 w-6 h-6 sm:w-8 sm:h-8 bg-green-500 rounded-full border-4 border-gray-800 flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-1 text-center sm:text-left">
                            <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white mb-2">{{ $user->name }}</h2>
                            <p class="text-gray-400 text-base sm:text-lg mb-3">{{ $user->email }}</p>
                            <div class="flex flex-col sm:flex-row items-center sm:items-start space-y-2 sm:space-y-0 sm:space-x-4 text-xs sm:text-sm">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-calendar-alt text-pink-500"></i>
                                    <span class="text-gray-300">Joined {{ $user->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-trophy text-yellow-500"></i>
                                    <span class="text-gray-300">{{ $achievements->count() }} Achievements</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($user->bio)
                        <div class="bg-gray-700/30 rounded-xl p-3 sm:p-4 mb-4 sm:mb-6">
                            <h3 class="text-base sm:text-lg font-semibold text-white mb-2">Bio</h3>
                            <p class="text-gray-300 leading-relaxed text-sm sm:text-base">{{ $user->bio }}</p>
                        </div>
                    @endif
                </div>

                <!-- Edit Profile Form -->
                <div class="bg-gray-800/50 backdrop-blur-xl rounded-2xl border border-gray-700/50 p-4 sm:p-6 lg:p-8 profile-card">
                    <h3 class="text-xl sm:text-2xl font-bold text-white mb-4 sm:mb-6 flex items-center">
                        <i class="fas fa-edit text-pink-500 mr-2 sm:mr-3"></i>
                        Edit Profile
                    </h3>

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4 sm:space-y-6 profile-form" onsubmit="return validateProfileForm()" id="profileForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="remove_avatar" id="remove_avatar" value="0">

                        <!-- Avatar Upload -->
                        <div class="space-y-3 sm:space-y-4">
                            <label class="block text-base sm:text-lg font-medium text-white">Profile Avatar</label>
                            <div class="flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-6 profile-avatar-section">
                                <div class="relative avatar-upload-area">
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-gradient-to-br from-pink-500 to-pink-700 flex items-center justify-center shadow-lg overflow-hidden profile-avatar-medium">
                                        @if($user->avatar)
                                            <img src="{{ \App\Helpers\AvatarHelper::getAvatarUrl($user->avatar) }}" alt="Current Avatar" class="w-full h-full object-cover" id="avatarPreview">
                                        @else
                                            <span class="text-white text-xl sm:text-2xl font-bold" id="avatarInitial">{{ substr($user->name, 0, 1) }}</span>
                                        @endif
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-5 h-5 sm:w-6 sm:h-6 bg-pink-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-camera text-white text-xs"></i>
                                    </div>
                                </div>
                                <div class="flex-1 text-center sm:text-left">
                                    <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden" onchange="previewAvatar(this)">
                                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                                        <label for="avatar" class="cursor-pointer inline-flex items-center px-3 sm:px-4 py-2 bg-pink-600 hover:bg-pink-700 text-white font-medium rounded-lg transition-colors duration-200 text-sm sm:text-base">
                                            <i class="fas fa-upload mr-2"></i>
                                            Upload Avatar
                                        </label>
                                        @if($user->avatar)
                                            <button type="button" onclick="removeAvatar()" class="inline-flex items-center px-3 sm:px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200 text-sm sm:text-base">
                                                <i class="fas fa-trash mr-2"></i>
                                                Remove Avatar
                                            </button>
                                        @endif
                                    </div>
                                    <p class="text-xs sm:text-sm text-gray-400 mt-2">Format: JPG, JPEG(Max: 2MB)</p>
                                </div>
                            </div>
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-base sm:text-lg font-medium text-white mb-2">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                                   class="w-full px-3 sm:px-4 py-2.5 sm:py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 text-sm sm:text-base">
                            @error('name')
                                <p class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-base sm:text-lg font-medium text-white mb-2">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                                   class="w-full px-3 sm:px-4 py-2.5 sm:py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 text-sm sm:text-base">
                            @error('email')
                                <p class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bio -->
                        <div>
                            <label for="bio" class="block text-base sm:text-lg font-medium text-white mb-2">Bio</label>
                            <textarea name="bio" id="bio" rows="3" placeholder="Tell us a little about yourself..." 
                                      class="w-full px-3 sm:px-4 py-2.5 sm:py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 resize-none text-sm sm:text-base">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <p class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="px-6 sm:px-8 py-2.5 sm:py-3 bg-gradient-to-r from-pink-600 to-pink-700 hover:from-pink-700 hover:to-pink-800 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg profile-btn text-sm sm:text-base">
                                <i class="fas fa-save mr-2"></i>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Password Form -->
                <div class="bg-gray-800/50 backdrop-blur-xl rounded-2xl border border-gray-700/50 p-4 sm:p-6 lg:p-8 profile-card">
                    <h3 class="text-xl sm:text-2xl font-bold text-white mb-4 sm:mb-6 flex items-center">
                        <i class="fas fa-lock text-pink-500 mr-2 sm:mr-3"></i>
                        Change Password
                    </h3>

                    <form action="{{ route('profile.change-password') }}" method="POST" class="space-y-4 sm:space-y-6 profile-form" onsubmit="return confirmPasswordChange().then(result => result.isConfirmed)">
                        @csrf

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-base sm:text-lg font-medium text-white mb-2">New Password</label>
                            <div class="relative">
                                <input type="password" name="password" id="password" 
                                       class="w-full px-3 sm:px-4 py-2.5 sm:py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 pr-12 text-sm sm:text-base"
                                       onkeyup="checkPasswordStrength(this.value)">
                                <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white">
                                    <i class="fas fa-eye" id="password_icon"></i>
                                </button>
                            </div>
                            <!-- Password Strength Indicator -->
                            <div class="mt-2">
                                <div class="flex items-center space-x-2 mb-1">
                                    <div class="flex-1 bg-gray-700 rounded-full h-2">
                                        <div id="passwordStrengthBar" class="h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                                    </div>
                                    <span id="passwordStrengthText" class="text-xs text-gray-400">Password strength</span>
                                </div>
                                <div id="passwordRequirements" class="text-xs space-y-1">
                                    <div class="flex items-center space-x-2">
                                        <i id="reqLength" class="fas fa-circle text-gray-500"></i>
                                        <span class="text-gray-400">Minimum 8 characters</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <i id="reqUppercase" class="fas fa-circle text-gray-500"></i>
                                        <span class="text-gray-400">At least 1 uppercase letter</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <i id="reqLowercase" class="fas fa-circle text-gray-500"></i>
                                        <span class="text-gray-400">At least 1 lowercase letter</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <i id="reqNumber" class="fas fa-circle text-gray-500"></i>
                                        <span class="text-gray-400">At least 1 number</span>
                                    </div>
                                </div>
                            </div>
                            @error('password')
                                <p class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-base sm:text-lg font-medium text-white mb-2">Confirm New Password</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                       class="w-full px-3 sm:px-4 py-2.5 sm:py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 pr-12 text-sm sm:text-base">
                                <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white">
                                    <i class="fas fa-eye" id="password_confirmation_icon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="px-6 sm:px-8 py-2.5 sm:py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg profile-btn text-sm sm:text-base">
                                <i class="fas fa-key mr-2"></i>
                                Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Achievements Sidebar -->
            <div class="space-y-6">
                <!-- Achievements Card -->
                <div class="bg-gray-800/50 backdrop-blur-xl rounded-2xl border border-gray-700/50 p-4 sm:p-6 profile-card">
                    <h3 class="text-xl sm:text-2xl font-bold text-white mb-4 sm:mb-6 flex items-center">
                        <i class="fas fa-trophy text-yellow-500 mr-2 sm:mr-3"></i>
                        Achievements
                    </h3>

                    @if($achievements->count() > 0)
                        <div class="space-y-3 sm:space-y-4">
                            @foreach($achievements as $achievement)
                                <div class="bg-gray-700/30 rounded-xl p-3 sm:p-4 border border-gray-600/50 achievement-card">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-yellow-500 to-yellow-600 flex items-center justify-center shadow-lg achievement-icon">
                                            <i class="fas fa-medal text-white text-sm sm:text-lg"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-white font-semibold text-xs sm:text-sm">{{ $achievement->title }}</h4>
                                            <p class="text-gray-400 text-xs">{{ $achievement->description }}</p>
                                            <div class="flex items-center space-x-2 mt-1">
                                                <i class="fas fa-calendar text-pink-500 text-xs"></i>
                                                <span class="text-gray-500 text-xs">{{ $achievement->created_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($achievements->count() >= 5)
                            <div class="mt-4 sm:mt-6 text-center">
                                <a href="{{ route('achievements.index') }}" class="inline-flex items-center px-3 sm:px-4 py-2 bg-pink-600 hover:bg-pink-700 text-white font-medium rounded-lg transition-colors duration-200 text-sm sm:text-base">
                                    <i class="fas fa-eye mr-2"></i>
                                    View All
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-6 sm:py-8">
                            <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-gray-700/50 flex items-center justify-center mx-auto mb-3 sm:mb-4">
                                <i class="fas fa-trophy text-gray-500 text-xl sm:text-2xl"></i>
                            </div>
                            <h4 class="text-gray-400 font-medium mb-2 text-sm sm:text-base">No Achievements Yet</h4>
                            <p class="text-gray-500 text-xs sm:text-sm">Start completing goals to earn achievements!</p>
                        </div>
                    @endif
                </div>

                <!-- Account Stats -->
                <div class="bg-gray-800/50 backdrop-blur-xl rounded-2xl border border-gray-700/50 p-4 sm:p-6 profile-card">
                    <h3 class="text-xl sm:text-2xl font-bold text-white mb-4 sm:mb-6 flex items-center">
                        <i class="fas fa-chart-bar text-green-500 mr-2 sm:mr-3"></i>
                        Account Statistics
                    </h3>

                    <div class="space-y-3 sm:space-y-4 profile-stats">
                        <div class="flex items-center justify-between p-3 sm:p-4 bg-gray-700/30 rounded-xl">
                            <div class="flex items-center space-x-2 sm:space-x-3">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                                    <i class="fas fa-bullseye text-white text-xs sm:text-sm"></i>
                                </div>
                                <span class="text-white font-medium text-sm sm:text-base">Goals</span>
                            </div>
                            <span class="text-xl sm:text-2xl font-bold text-blue-400">{{ $user->goals()->count() }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3 sm:p-4 bg-gray-700/30 rounded-xl">
                            <div class="flex items-center space-x-2 sm:space-x-3">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                                    <i class="fas fa-tasks text-white text-xs sm:text-sm"></i>
                                </div>
                                <span class="text-white font-medium text-sm sm:text-base">Tasks</span>
                            </div>
                            <span class="text-xl sm:text-2xl font-bold text-purple-400">{{ $user->tasks()->count() }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3 sm:p-4 bg-gray-700/30 rounded-xl">
                            <div class="flex items-center space-x-2 sm:space-x-3">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center">
                                    <i class="fas fa-book-open text-white text-xs sm:text-sm"></i>
                                </div>
                                <span class="text-white font-medium text-sm sm:text-base">Journals</span>
                            </div>
                            <span class="text-xl sm:text-2xl font-bold text-green-400">{{ $user->journals()->count() }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3 sm:p-4 bg-gray-700/30 rounded-xl">
                            <div class="flex items-center space-x-2 sm:space-x-3">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-yellow-500 to-yellow-600 flex items-center justify-center">
                                    <i class="fas fa-trophy text-white text-xs sm:text-sm"></i>
                                </div>
                                <span class="text-white font-medium text-sm sm:text-base">Achievements</span>
                            </div>
                            <span class="text-xl sm:text-2xl font-bold text-yellow-400">{{ $user->achievements()->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Find the avatar container within the same section
            const avatarSection = input.closest('.profile-avatar-section');
            const avatarContainer = avatarSection.querySelector('.profile-avatar-medium');
            const initial = document.getElementById('avatarInitial');
            
            // Create new image element
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Avatar Preview';
            img.className = 'w-full h-full object-cover';
            img.id = 'avatarPreview';
            
            // Clear container and add new image
            if (avatarContainer) {
                avatarContainer.innerHTML = '';
                avatarContainer.appendChild(img);
            }
            
            // Hide initial if it exists
            if (initial) {
                initial.style.display = 'none';
            }
            
            // Reset remove avatar flag
            document.getElementById('remove_avatar').value = '0';
            
            // Also update the large avatar preview at the top
            const largeAvatarContainer = document.querySelector('.profile-avatar-large');
            if (largeAvatarContainer) {
                const largeImg = document.createElement('img');
                largeImg.src = e.target.result;
                largeImg.alt = 'Avatar Preview';
                largeImg.className = 'w-full h-full object-cover';
                largeAvatarContainer.innerHTML = '';
                largeAvatarContainer.appendChild(largeImg);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removeAvatar() {
    if (confirm('Are you sure you want to remove your avatar?')) {
        const avatarContainer = document.querySelector('.profile-avatar-medium');
        const largeAvatarContainer = document.querySelector('.profile-avatar-large');
        const initial = document.getElementById('avatarInitial');
        const removeAvatarInput = document.getElementById('remove_avatar');
        
        // Clear avatar containers
        avatarContainer.innerHTML = '';
        if (largeAvatarContainer) {
            largeAvatarContainer.innerHTML = '';
        }
        
        // Show initial in both containers
        if (initial) {
            initial.style.display = 'block';
            // Clone initial for large container
            const largeInitial = initial.cloneNode(true);
            largeInitial.id = 'avatarInitialLarge';
            if (largeAvatarContainer) {
                largeAvatarContainer.appendChild(largeInitial);
            }
        }
        
        // Set remove avatar flag
        removeAvatarInput.value = '1';
        
        // Clear file input
        document.getElementById('avatar').value = '';
    }
}

function validateProfileForm() {
    console.log('Validating profile form...');
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const bio = document.getElementById('bio').value.trim();
    const avatar = document.getElementById('avatar').files[0];
    const removeAvatar = document.getElementById('remove_avatar').value;
    
    console.log('Form values:', { name, email, bio, avatar: avatar ? 'file selected' : 'no file', removeAvatar });
    
    // Basic validation
    if (!name) {
        alert('Name is required.');
        document.getElementById('name').focus();
        return false;
    }
    
    if (!email) {
        alert('Email is required.');
        document.getElementById('email').focus();
        return false;
    }
    
    // Simple email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert('Please enter a valid email address.');
        document.getElementById('email').focus();
        return false;
    }
    
    // Check if any field has changed
    const originalName = '{{ $user->name }}';
    const originalEmail = '{{ $user->email }}';
    const originalBio = '{{ $user->bio ?? "" }}';
    const hasAvatar = '{{ $user->avatar ? "true" : "false" }}';
    
    console.log('Original values:', { originalName, originalEmail, originalBio, hasAvatar });
    
    const hasChanges = name !== originalName || 
                      email !== originalEmail || 
                      bio !== originalBio || 
                      avatar || 
                      (removeAvatar === '1' && hasAvatar === 'true');
    
    console.log('Has changes:', hasChanges);
    
    if (!hasChanges) {
        alert('No changes detected. Please make changes before saving.');
        return false;
    }
    
    console.log('Form validation passed');
    return true;
}

function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '_icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function checkPasswordStrength(password) {
    const strengthBar = document.getElementById('passwordStrengthBar');
    const strengthText = document.getElementById('passwordStrengthText');
    
    // Password requirements
    const requirements = {
        length: password.length >= 8,
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        number: /[0-9]/.test(password)
    };
    
    // Update requirement indicators
    document.getElementById('reqLength').className = requirements.length ? 'fas fa-check text-green-500' : 'fas fa-circle text-gray-500';
    document.getElementById('reqUppercase').className = requirements.uppercase ? 'fas fa-check text-green-500' : 'fas fa-circle text-gray-500';
    document.getElementById('reqLowercase').className = requirements.lowercase ? 'fas fa-check text-green-500' : 'fas fa-circle text-gray-500';
    document.getElementById('reqNumber').className = requirements.number ? 'fas fa-check text-green-500' : 'fas fa-circle text-gray-500';
    
    // Calculate strength
    const metRequirements = Object.values(requirements).filter(Boolean).length;
    const strength = (metRequirements / 4) * 100;
    
    // Update strength bar
    strengthBar.style.width = strength + '%';
    
    // Update strength bar color and text
    if (strength < 25) {
        strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-red-500';
        strengthText.textContent = 'Very Weak';
        strengthText.className = 'text-xs text-red-400';
    } else if (strength < 50) {
        strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-orange-500';
        strengthText.textContent = 'Weak';
        strengthText.className = 'text-xs text-orange-400';
    } else if (strength < 75) {
        strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-yellow-500';
        strengthText.textContent = 'Medium';
        strengthText.className = 'text-xs text-yellow-400';
    } else if (strength < 100) {
        strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-blue-500';
        strengthText.textContent = 'Strong';
        strengthText.className = 'text-xs text-blue-400';
    } else {
        strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-green-500';
        strengthText.textContent = 'Very Strong';
        strengthText.className = 'text-xs text-green-400';
    }
}

// Add loading animation for form submission
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.profile-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            console.log('Form submission started');
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
            submitBtn.disabled = true;
            
            // Re-enable after 5 seconds if form doesn't submit
            setTimeout(() => {
                if (submitBtn.disabled) {
                    console.log('Form submission timeout, re-enabling button');
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            }, 5000);
        });
    });
    
    // Add success animation for achievement cards
    const achievementCards = document.querySelectorAll('.achievement-card');
    achievementCards.forEach((card, index) => {
        card.style.animationDelay = (index * 0.1) + 's';
    });
    

});

// Add confirmation for password change
function confirmPasswordChange() {
    return Swal.fire({
        title: 'Change Password?',
        text: 'Are you sure you want to change your password? You will be logged out after the password is successfully changed.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Change Password',
        cancelButtonText: 'Cancel',
        background: 'linear-gradient(to top right, #1f2937, #374151)',
        customClass: {
            popup: 'rounded-2xl shadow-2xl border border-gray-700',
            title: 'text-xl sm:text-2xl font-bold text-pink-400 pt-4',
            htmlContainer: 'text-base sm:text-lg text-gray-300 pb-4',
            actions: 'w-full flex justify-center gap-x-4 px-4',
            confirmButton: 'bg-pink-500 hover:bg-pink-600 text-white font-bold py-2.5 sm:py-3 px-6 sm:px-8 rounded-lg shadow-lg text-sm sm:text-base',
            cancelButton: 'bg-gray-600 hover:bg-gray-700 text-white font-bold py-2.5 sm:py-3 px-6 sm:px-8 rounded-lg shadow-lg text-sm sm:text-base'
        },
        buttonsStyling: false,
        focusCancel: true
    });
}
</script>
@endsection 