@extends('layouts.app')

@section('content')
<div class="container mx-auto px-2 sm:px-4 py-4 sm:py-8 text-gray-200 lg:px-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6 sm:mb-8">
        <div>
            <h1 class="text-3xl sm:text-4xl font-bold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow">
                🔒 Secret Admin Dashboard
            </h1>
            <p class="text-gray-400 mt-2">Welcome to the hidden admin panel</p>
        </div>
        <div class="text-right">
            <div class="text-lg sm:text-xl font-bold text-white font-mono">{{ now()->format('H:i:s') }}</div>
            <div class="text-xs sm:text-sm text-gray-300">{{ now()->format('M d, Y') }}</div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-900/40 to-blue-800/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-blue-700/40 transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm sm:text-lg font-semibold text-blue-300">Total Users</h3>
                    <p class="text-2xl sm:text-3xl font-bold text-white">{{ $analytics['total_users'] }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500/20 to-blue-700/20 rounded-full flex items-center justify-center border border-blue-500/30">
                    <i class="fas fa-users text-2xl text-blue-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-900/40 to-green-800/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-green-700/40 transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm sm:text-lg font-semibold text-green-300">Active Users</h3>
                    <p class="text-2xl sm:text-3xl font-bold text-white">{{ $analytics['active_users'] }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-green-500/20 to-green-700/20 rounded-full flex items-center justify-center border border-green-500/30">
                    <i class="fas fa-user-check text-2xl text-green-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-900/40 to-purple-800/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-purple-700/40 transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm sm:text-lg font-semibold text-purple-300">Inactive Users</h3>
                    <p class="text-2xl sm:text-3xl font-bold text-white">{{ $analytics['inactive_users'] }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500/20 to-purple-700/20 rounded-full flex items-center justify-center border border-purple-500/30">
                    <i class="fas fa-user-times text-2xl text-purple-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-pink-900/40 to-pink-800/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-pink-700/40 transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm sm:text-lg font-semibold text-pink-300">Total Activities</h3>
                    <p class="text-2xl sm:text-3xl font-bold text-white">{{ array_sum($analytics['activity_distribution']) }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-pink-500/20 to-pink-700/20 rounded-full flex items-center justify-center border border-pink-500/30">
                    <i class="fas fa-chart-bar text-2xl text-pink-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 mb-8">
        <!-- User Growth Chart -->
        <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-gray-700/40">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg sm:text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-chart-line text-pink-400 mr-2"></i>
                    User Growth (12 Months)
                </h3>
            </div>
            <div class="h-64">
                <canvas id="userGrowthChart"></canvas>
            </div>
        </div>

        <!-- Activity Distribution Chart -->
        <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-gray-700/40">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg sm:text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-chart-pie text-pink-400 mr-2"></i>
                    Activity Distribution
                </h3>
            </div>
            <div class="h-64">
                <canvas id="activityChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Additional Analytics Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 mb-8">
        <!-- Goals Completion Rate -->
        <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-gray-700/40">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-bullseye text-green-400 mr-2"></i>
                    Goals Completion
                </h3>
            </div>
            <div class="h-48">
                <canvas id="goalsCompletionChart"></canvas>
            </div>
        </div>

        <!-- Tasks Completion Rate -->
        <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-gray-700/40">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-tasks text-yellow-400 mr-2"></i>
                    Tasks Completion
                </h3>
            </div>
            <div class="h-48">
                <canvas id="tasksCompletionChart"></canvas>
            </div>
        </div>

        <!-- Activity by Day of Week -->
        <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-gray-700/40">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-calendar-week text-blue-400 mr-2"></i>
                    Activity by Day
                </h3>
            </div>
            <div class="h-48">
                <canvas id="activityByDayChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Priority and Status Distribution -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 mb-8">
        <!-- Task Priority Distribution -->
        <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-gray-700/40">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-400 mr-2"></i>
                    Task Priority Distribution
                </h3>
            </div>
            <div class="h-48">
                <canvas id="taskPriorityChart"></canvas>
            </div>
        </div>

        <!-- Goal Status Distribution -->
        <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-gray-700/40">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-flag text-purple-400 mr-2"></i>
                    Goal Status Distribution
                </h3>
            </div>
            <div class="h-48">
                <canvas id="goalStatusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Most Active Users Section -->
    <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-gray-700/40 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg sm:text-xl font-semibold text-white flex items-center">
                <i class="fas fa-trophy text-yellow-400 mr-2"></i>
                Most Active Users
            </h3>
            <span class="text-sm text-gray-400">Top 5 by total activities</span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
            @foreach($analytics['most_active_users'] as $index => $user)
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-4 border border-gray-700/40 hover:bg-gray-800/70 transition-all duration-300">
                <div class="flex items-center mb-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-500 to-pink-700 flex items-center justify-center text-white font-bold text-lg mr-3">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <h4 class="text-white font-semibold text-sm">{{ $user->name }}</h4>
                        <p class="text-gray-400 text-xs">{{ $user->email }}</p>
                    </div>
                    @if($index < 3)
                    <div class="w-6 h-6 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center text-white text-xs font-bold">
                        {{ $index + 1 }}
                    </div>
                    @endif
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-400">Total Activities:</span>
                        <span class="text-white font-semibold">{{ $user->total_activities }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-400">Goals:</span>
                        <span class="text-green-400">{{ $user->goals_count }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-400">Tasks:</span>
                        <span class="text-blue-400">{{ $user->tasks_count }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-400">Journals:</span>
                        <span class="text-purple-400">{{ $user->journals_count }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- User Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
        <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-gray-700/40">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500/20 to-blue-700/20 rounded-full flex items-center justify-center border border-blue-500/30 mx-auto mb-3">
                    <i class="fas fa-calendar-day text-2xl text-blue-400"></i>
                </div>
                <h4 class="text-sm font-semibold text-gray-300 mb-1">Today</h4>
                <p class="text-2xl font-bold text-white">{{ $userStats['users_today'] }}</p>
                <p class="text-xs text-gray-400">New users</p>
            </div>
        </div>

        <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-gray-700/40">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500/20 to-green-700/20 rounded-full flex items-center justify-center border border-green-500/30 mx-auto mb-3">
                    <i class="fas fa-calendar-week text-2xl text-green-400"></i>
                </div>
                <h4 class="text-sm font-semibold text-gray-300 mb-1">This Week</h4>
                <p class="text-2xl font-bold text-white">{{ $userStats['users_this_week'] }}</p>
                <p class="text-xs text-gray-400">New users</p>
            </div>
        </div>

        <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-gray-700/40">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500/20 to-purple-700/20 rounded-full flex items-center justify-center border border-purple-500/30 mx-auto mb-3">
                    <i class="fas fa-calendar-alt text-2xl text-purple-400"></i>
                </div>
                <h4 class="text-sm font-semibold text-gray-300 mb-1">This Month</h4>
                <p class="text-2xl font-bold text-white">{{ $userStats['users_this_month'] }}</p>
                <p class="text-xs text-gray-400">New users</p>
            </div>
        </div>

        <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-gray-700/40">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-pink-500/20 to-pink-700/20 rounded-full flex items-center justify-center border border-pink-500/30 mx-auto mb-3">
                    <i class="fas fa-chart-bar text-2xl text-pink-400"></i>
                </div>
                <h4 class="text-sm font-semibold text-gray-300 mb-1">Total</h4>
                <p class="text-2xl font-bold text-white">{{ $userStats['total_users'] }}</p>
                <p class="text-xs text-gray-400">All users</p>
            </div>
        </div>
    </div>

    <!-- Recent Users Table -->
    <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-4 sm:p-6 border border-gray-700/40">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg sm:text-xl font-semibold text-white flex items-center">
                <i class="fas fa-users text-pink-400 mr-2"></i>
                Recent Users
            </h3>
            <a href="{{ route('secret.users') }}" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-lg transform hover:scale-105 transition-all duration-300">
                View All Users
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Activities</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @foreach($recentUsers as $user)
                    <tr class="hover:bg-gray-700 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-pink-500 to-pink-700 flex items-center justify-center text-white font-semibold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-white">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-300">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-300">{{ $user->created_at->format('M d, Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $user->goals->count() }} Goals
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $user->tasks->count() }} Tasks
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('secret.user.detail', $user->id) }}" class="text-pink-500 hover:text-pink-400">
                                View Details
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // User Growth Chart
    const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
    const userGrowthData = @json($analytics['user_growth']);
    
    new Chart(userGrowthCtx, {
        type: 'line',
        data: {
            labels: userGrowthData.map(item => {
                const date = new Date(item.month + '-01');
                return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
            }),
            datasets: [{
                label: 'New Users',
                data: userGrowthData.map(item => item.count),
                borderColor: 'rgb(236, 72, 153)',
                backgroundColor: 'rgba(236, 72, 153, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgb(236, 72, 153)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: '#d1d5db'
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#9ca3af'
                    },
                    grid: {
                        color: 'rgba(75, 85, 99, 0.3)'
                    }
                },
                y: {
                    ticks: {
                        color: '#9ca3af'
                    },
                    grid: {
                        color: 'rgba(75, 85, 99, 0.3)'
                    }
                }
            }
        }
    });

    // Activity Distribution Chart
    const activityCtx = document.getElementById('activityChart').getContext('2d');
    const activityData = @json($analytics['activity_distribution']);
    
    new Chart(activityCtx, {
        type: 'doughnut',
        data: {
            labels: ['Categories', 'Goals', 'Completed Goals', 'Tasks', 'Completed Tasks', 'Journals', 'Achievements'],
            datasets: [{
                data: [
                    activityData.categories,
                    activityData.goals,
                    activityData.completed_goals,
                    activityData.tasks,
                    activityData.completed_tasks,
                    activityData.journals,
                    activityData.achievements
                ],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(251, 191, 36, 0.8)',
                    'rgba(139, 92, 246, 0.8)',
                    'rgba(236, 72, 153, 0.8)'
                ],
                borderColor: [
                    'rgb(59, 130, 246)',
                    'rgb(16, 185, 129)',
                    'rgb(34, 197, 94)',
                    'rgb(245, 158, 11)',
                    'rgb(251, 191, 36)',
                    'rgb(139, 92, 246)',
                    'rgb(236, 72, 153)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#d1d5db',
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });

    // Goals Completion Chart
    const goalsCompletionCtx = document.getElementById('goalsCompletionChart').getContext('2d');
    const goalsCompletionData = @json($analytics['goals_completion']);
    
    new Chart(goalsCompletionCtx, {
        type: 'bar',
        data: {
            labels: goalsCompletionData.length > 0 ? goalsCompletionData.map(item => {
                const date = new Date(item.month + '-01');
                return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
            }) : ['No Data'],
            datasets: [{
                label: 'Total Goals',
                data: goalsCompletionData.length > 0 ? goalsCompletionData.map(item => item.total) : [0],
                backgroundColor: 'rgba(16, 185, 129, 0.6)',
                borderColor: 'rgb(16, 185, 129)',
                borderWidth: 1
            }, {
                label: 'Completed Goals',
                data: goalsCompletionData.length > 0 ? goalsCompletionData.map(item => item.completed) : [0],
                backgroundColor: 'rgba(34, 197, 94, 0.8)',
                borderColor: 'rgb(34, 197, 94)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: '#d1d5db'
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#9ca3af'
                    },
                    grid: {
                        color: 'rgba(75, 85, 99, 0.3)'
                    }
                },
                y: {
                    ticks: {
                        color: '#9ca3af'
                    },
                    grid: {
                        color: 'rgba(75, 85, 99, 0.3)'
                    }
                }
            }
        }
    });

    // Tasks Completion Chart
    const tasksCompletionCtx = document.getElementById('tasksCompletionChart').getContext('2d');
    const tasksCompletionData = @json($analytics['tasks_completion']);
    
    new Chart(tasksCompletionCtx, {
        type: 'bar',
        data: {
            labels: tasksCompletionData.length > 0 ? tasksCompletionData.map(item => {
                const date = new Date(item.month + '-01');
                return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
            }) : ['No Data'],
            datasets: [{
                label: 'Total Tasks',
                data: tasksCompletionData.length > 0 ? tasksCompletionData.map(item => item.total) : [0],
                backgroundColor: 'rgba(245, 158, 11, 0.6)',
                borderColor: 'rgb(245, 158, 11)',
                borderWidth: 1
            }, {
                label: 'Completed Tasks',
                data: tasksCompletionData.length > 0 ? tasksCompletionData.map(item => item.completed) : [0],
                backgroundColor: 'rgba(251, 191, 36, 0.8)',
                borderColor: 'rgb(251, 191, 36)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: '#d1d5db'
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#9ca3af'
                    },
                    grid: {
                        color: 'rgba(75, 85, 99, 0.3)'
                    }
                },
                y: {
                    ticks: {
                        color: '#9ca3af'
                    },
                    grid: {
                        color: 'rgba(75, 85, 99, 0.3)'
                    }
                }
            }
        }
    });

    // Activity by Day Chart
    const activityByDayCtx = document.getElementById('activityByDayChart').getContext('2d');
    const activityByDayData = @json($analytics['activity_by_day']);
    
    new Chart(activityByDayCtx, {
        type: 'bar',
        data: {
            labels: activityByDayData.length > 0 ? activityByDayData.map(item => item.day_name) : ['No Data'],
            datasets: [{
                label: 'User Registrations',
                data: activityByDayData.length > 0 ? activityByDayData.map(item => item.count) : [0],
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: '#d1d5db'
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#9ca3af'
                    },
                    grid: {
                        color: 'rgba(75, 85, 99, 0.3)'
                    }
                },
                y: {
                    ticks: {
                        color: '#9ca3af'
                    },
                    grid: {
                        color: 'rgba(75, 85, 99, 0.3)'
                    }
                }
            }
        }
    });

    // Task Priority Chart
    const taskPriorityCtx = document.getElementById('taskPriorityChart').getContext('2d');
    const taskPriorityData = @json($analytics['task_priority_distribution']);
    
    new Chart(taskPriorityCtx, {
        type: 'doughnut',
        data: {
            labels: taskPriorityData.map(item => item.priority.charAt(0).toUpperCase() + item.priority.slice(1)),
            datasets: [{
                data: taskPriorityData.map(item => item.count),
                backgroundColor: [
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(34, 197, 94, 0.8)'
                ],
                borderColor: [
                    'rgb(239, 68, 68)',
                    'rgb(245, 158, 11)',
                    'rgb(34, 197, 94)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#d1d5db',
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });

    // Goal Status Chart
    const goalStatusCtx = document.getElementById('goalStatusChart').getContext('2d');
    const goalStatusData = @json($analytics['goal_status_distribution']);
    
    new Chart(goalStatusCtx, {
        type: 'doughnut',
        data: {
            labels: goalStatusData.map(item => item.status.charAt(0).toUpperCase() + item.status.slice(1).replace('_', ' ')),
            datasets: [{
                data: goalStatusData.map(item => item.count),
                backgroundColor: [
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(245, 158, 11, 0.8)'
                ],
                borderColor: [
                    'rgb(34, 197, 94)',
                    'rgb(59, 130, 246)',
                    'rgb(245, 158, 11)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#d1d5db',
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });
});
</script>
@endsection
