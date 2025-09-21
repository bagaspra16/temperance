@extends('layouts.app')

@section('content')
<div class="container mx-auto px-2 sm:px-4 py-4 sm:py-8 text-gray-200 lg:px-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 sm:mb-8">
        <div class="flex items-center">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-pink-500 to-pink-700 flex items-center justify-center text-white font-bold text-2xl mr-4">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div>
                <h1 class="text-3xl sm:text-4xl font-bold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow">
                    {{ $user->name }}
                </h1>
                <p class="text-gray-400 mt-1">{{ $user->email }}</p>
                <p class="text-sm text-gray-500">Joined {{ $user->created_at->format('M d, Y') }} ({{ $user->created_at->diffForHumans() }})</p>
            </div>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-2">
            <a href="{{ route('secret.users') }}" class="bg-gradient-to-r from-gray-500 to-gray-700 hover:from-gray-600 hover:to-gray-800 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-lg transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-arrow-left mr-2"></i>Back to Users
            </a>
            <a href="{{ route('secret.dashboard') }}" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-lg transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
            </a>
        </div>
    </div>

    <!-- User Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-900/40 to-blue-800/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-blue-700/40">
            <div class="text-center">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500/20 to-blue-700/20 rounded-full flex items-center justify-center border border-blue-500/30 mx-auto mb-3">
                    <i class="fas fa-folder text-xl text-blue-400"></i>
                </div>
                <h4 class="text-sm font-semibold text-blue-300 mb-1">Categories</h4>
                <p class="text-2xl font-bold text-white">{{ $userStats['total_categories'] }}</p>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-900/40 to-green-800/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-green-700/40">
            <div class="text-center">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500/20 to-green-700/20 rounded-full flex items-center justify-center border border-green-500/30 mx-auto mb-3">
                    <i class="fas fa-bullseye text-xl text-green-400"></i>
                </div>
                <h4 class="text-sm font-semibold text-green-300 mb-1">Goals</h4>
                <p class="text-2xl font-bold text-white">{{ $userStats['total_goals'] }}</p>
                <p class="text-xs text-gray-400">{{ $userStats['completed_goals'] }} completed</p>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-900/40 to-yellow-800/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-yellow-700/40">
            <div class="text-center">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500/20 to-yellow-700/20 rounded-full flex items-center justify-center border border-yellow-500/30 mx-auto mb-3">
                    <i class="fas fa-tasks text-xl text-yellow-400"></i>
                </div>
                <h4 class="text-sm font-semibold text-yellow-300 mb-1">Tasks</h4>
                <p class="text-2xl font-bold text-white">{{ $userStats['total_tasks'] }}</p>
                <p class="text-xs text-gray-400">{{ $userStats['completed_tasks'] }} completed</p>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-900/40 to-purple-800/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-purple-700/40">
            <div class="text-center">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500/20 to-purple-700/20 rounded-full flex items-center justify-center border border-purple-500/30 mx-auto mb-3">
                    <i class="fas fa-book text-xl text-purple-400"></i>
                </div>
                <h4 class="text-sm font-semibold text-purple-300 mb-1">Journals</h4>
                <p class="text-2xl font-bold text-white">{{ $userStats['total_journals'] }}</p>
            </div>
        </div>
    </div>

    <!-- User Information -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 mb-8">
        <!-- User Profile -->
        <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-gray-700/40">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-user text-pink-400 mr-2"></i>
                Profile Information
            </h3>
            <div class="space-y-3">
                <div>
                    <label class="text-sm font-medium text-gray-400">Name</label>
                    <p class="text-white">{{ $user->name }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-400">Email</label>
                    <div class="flex items-center space-x-2">
                        <p class="text-white">{{ $user->email }}</p>
                        <button onclick="copyToClipboard('{{ $user->email }}')" class="text-pink-400 hover:text-pink-300 text-sm">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-400">Password</label>
                    <div class="flex items-center space-x-2">
                        <input type="password" id="passwordField" value="••••••••" readonly class="bg-gray-800 text-white px-3 py-1 rounded border border-gray-600 text-sm">
                        <button onclick="togglePassword()" class="text-pink-400 hover:text-pink-300 text-sm">
                            <i class="fas fa-eye" id="passwordToggle"></i>
                        </button>
                        <button onclick="copyToClipboard('{{ $user->password }}')" class="text-pink-400 hover:text-pink-300 text-sm">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Click eye icon to reveal password</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-400">Bio</label>
                    <p class="text-white">{{ $user->bio ?: 'No bio provided' }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-400">Member Since</label>
                    <p class="text-white">{{ $user->created_at->format('F j, Y \a\t g:i A') }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-400">Last Updated</label>
                    <p class="text-white">{{ $user->updated_at->format('F j, Y \a\t g:i A') }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-400">Email Verified</label>
                    <div class="flex items-center space-x-2">
                        @if($user->email_verified_at)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Verified
                            </span>
                            <span class="text-xs text-gray-500">{{ $user->email_verified_at->format('M d, Y') }}</span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-1"></i>
                                Not Verified
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-gray-700/40">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-folder text-blue-400 mr-2"></i>
                Categories ({{ $user->categories->count() }})
            </h3>
            @if($user->categories->count() > 0)
                <div class="space-y-2 max-h-64 overflow-y-auto">
                    @foreach($user->categories as $category)
                        <div class="flex items-center justify-between p-3 bg-gray-800/50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $category->color }}"></div>
                                <span class="text-white text-sm">{{ $category->name }}</span>
                            </div>
                            <span class="text-xs text-gray-400">{{ $category->goals->count() }} goals</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-sm">No categories created yet</p>
            @endif
        </div>

        <!-- Recent Activity -->
        <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-gray-700/40">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-clock text-green-400 mr-2"></i>
                Recent Activity
            </h3>
            @if($recentActivity->count() > 0)
                <div class="space-y-3 max-h-64 overflow-y-auto">
                    @foreach($recentActivity as $activity)
                        <div class="flex items-start space-x-3 p-2 bg-gray-800/50 rounded-lg">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-semibold
                                @if($activity['type'] === 'goal') bg-blue-500/20 text-blue-400
                                @elseif($activity['type'] === 'task') bg-yellow-500/20 text-yellow-400
                                @else bg-purple-500/20 text-purple-400 @endif">
                                @if($activity['type'] === 'goal')
                                    <i class="fas fa-bullseye"></i>
                                @elseif($activity['type'] === 'task')
                                    <i class="fas fa-tasks"></i>
                                @else
                                    <i class="fas fa-book"></i>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-white text-sm font-medium truncate">{{ $activity['title'] }}</p>
                                <p class="text-gray-400 text-xs">
                                    {{ ucfirst($activity['type']) }} • {{ $activity['updated_at']->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-sm">No recent activity</p>
            @endif
        </div>
    </div>

    <!-- Goals and Tasks -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 mb-8">
        <!-- Goals -->
        <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-gray-700/40">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-bullseye text-green-400 mr-2"></i>
                Goals ({{ $user->goals->count() }})
            </h3>
            @if($user->goals->count() > 0)
                <div class="space-y-3 max-h-80 overflow-y-auto">
                    @foreach($user->goals->take(10) as $goal)
                        <div class="p-3 bg-gray-800/50 rounded-lg">
                            <div class="flex items-start justify-between mb-2">
                                <h4 class="text-white text-sm font-medium">{{ $goal->title }}</h4>
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    @if($goal->status === 'completed') bg-green-100 text-green-800
                                    @elseif($goal->status === 'in_progress') bg-blue-100 text-blue-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $goal->status)) }}
                                </span>
                            </div>
                            <div class="mb-2">
                                <div class="w-full bg-gray-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full" 
                                         style="width: {{ $goal->progress_percent }}%"></div>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">{{ $goal->progress_percent }}% complete</p>
                            </div>
                            @if($goal->category)
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $goal->category->color }}"></div>
                                    <span class="text-xs text-gray-400">{{ $goal->category->name }}</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-sm">No goals created yet</p>
            @endif
        </div>

        <!-- Tasks -->
        <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-gray-700/40">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-tasks text-yellow-400 mr-2"></i>
                Tasks ({{ $user->tasks->count() }})
            </h3>
            @if($user->tasks->count() > 0)
                <div class="space-y-3 max-h-80 overflow-y-auto">
                    @foreach($user->tasks->take(10) as $task)
                        <div class="p-3 bg-gray-800/50 rounded-lg">
                            <div class="flex items-start justify-between mb-2">
                                <h4 class="text-white text-sm font-medium">{{ $task->title }}</h4>
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    @if($task->status === 'completed') bg-green-100 text-green-800
                                    @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-xs text-gray-400">
                                <span>Priority: {{ ucfirst($task->priority) }}</span>
                                @if($task->due_date)
                                    <span>Due: {{ $task->due_date->format('M d, Y') }}</span>
                                @endif
                            </div>
                            @if($task->goal)
                                <div class="mt-2">
                                    <span class="text-xs text-gray-400">Goal: {{ $task->goal->title }}</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-sm">No tasks created yet</p>
            @endif
        </div>
    </div>

    <!-- Journals -->
    <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-gray-700/40">
        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
            <i class="fas fa-book text-purple-400 mr-2"></i>
            Journals ({{ $user->journals->count() }})
        </h3>
        @if($user->journals->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($user->journals->take(9) as $journal)
                    <div class="p-4 bg-gray-800/50 rounded-lg">
                        <h4 class="text-white text-sm font-medium mb-2">{{ $journal->title }}</h4>
                        <p class="text-gray-400 text-xs mb-2 line-clamp-3">{{ $journal->content }}</p>
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span>{{ $journal->created_at->format('M d, Y') }}</span>
                            <span>{{ $journal->mood ?? 'No mood' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-400 text-sm">No journals created yet</p>
        @endif
    </div>
</div>

<script>
// Copy to clipboard function
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        toast.textContent = 'Copied to clipboard!';
        document.body.appendChild(toast);
        
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 2000);
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        toast.textContent = 'Copied to clipboard!';
        document.body.appendChild(toast);
        
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 2000);
    });
}

// Toggle password visibility
function togglePassword() {
    const passwordField = document.getElementById('passwordField');
    const passwordToggle = document.getElementById('passwordToggle');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        passwordField.value = '{{ $user->password }}';
        passwordToggle.className = 'fas fa-eye-slash';
    } else {
        passwordField.type = 'password';
        passwordField.value = '••••••••';
        passwordToggle.className = 'fas fa-eye';
    }
}
</script>
@endsection
