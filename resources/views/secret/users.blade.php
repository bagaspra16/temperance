@extends('layouts.app')

@section('content')
<div class="container mx-auto px-2 sm:px-4 py-4 sm:py-8 text-gray-200 lg:px-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 sm:mb-8">
        <div>
            <h1 class="text-3xl sm:text-4xl font-bold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow">
                👥 User Management
            </h1>
            <p class="text-gray-400 mt-2">Manage and monitor all users in the system</p>
        </div>
        <a href="{{ route('secret.dashboard') }}" class="mt-4 sm:mt-0 bg-gradient-to-r from-gray-500 to-gray-700 hover:from-gray-600 hover:to-gray-800 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-lg transform hover:scale-105 transition-all duration-300">
            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
        </a>
    </div>

    <!-- Search and Filters -->
    <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-gray-700/40 mb-6">
        <form method="GET" action="{{ route('secret.users') }}" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-300 mb-2">Search Users</label>
                <div class="relative">
                    <input type="text" 
                           id="search" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search by name or email..."
                           class="w-full px-4 py-2 pl-10 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
            </div>
            
            <div class="sm:w-48">
                <label for="sort" class="block text-sm font-medium text-gray-300 mb-2">Sort By</label>
                <select name="sort" id="sort" class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Join Date</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                    <option value="email" {{ request('sort') == 'email' ? 'selected' : '' }}>Email</option>
                </select>
            </div>
            
            <div class="sm:w-32">
                <label for="direction" class="block text-sm font-medium text-gray-300 mb-2">Order</label>
                <select name="direction" id="direction" class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                </select>
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white px-6 py-2 rounded-lg text-sm font-semibold shadow-lg transform hover:scale-105 transition-all duration-300">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg border border-gray-700/40 overflow-hidden">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-700">
            <h3 class="text-lg font-semibold text-white">
                Users ({{ $users->total() }} total)
            </h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Activities</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-700 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-500 to-pink-700 flex items-center justify-center text-white font-semibold text-lg">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-white">{{ $user->name }}</div>
                                    @if($user->bio)
                                        <div class="text-xs text-gray-400 truncate max-w-xs">{{ $user->bio }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-300">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-300">{{ $user->created_at->format('M d, Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-wrap gap-1">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $user->categories->count() }} Categories
                                </span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $user->goals->count() }} Goals
                                </span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    {{ $user->tasks->count() }} Tasks
                                </span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    {{ $user->journals->count() }} Journals
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $isActive = $user->tasks()->where('updated_at', '>=', now()->subDays(30))->exists() ||
                                           $user->goals()->where('updated_at', '>=', now()->subDays(30))->exists() ||
                                           $user->journals()->where('updated_at', '>=', now()->subDays(30))->exists();
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $isActive ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                <div class="w-1.5 h-1.5 rounded-full {{ $isActive ? 'bg-green-400' : 'bg-gray-400' }} mr-1.5"></div>
                                {{ $isActive ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('secret.user.detail', $user->id) }}" 
                               class="text-pink-500 hover:text-pink-400 mr-4 transition-colors duration-200">
                                <i class="fas fa-eye mr-1"></i>View Details
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <i class="fas fa-users text-4xl mb-4"></i>
                                <p class="text-lg">No users found</p>
                                <p class="text-sm">Try adjusting your search criteria</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($users->hasPages())
        <div class="px-4 sm:px-6 py-4 border-t border-gray-700">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
