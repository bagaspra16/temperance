@extends('layouts.app')

@section('content')
<div class="container mx-auto px-2 sm:px-4 py-4 sm:py-8 text-gray-200 lg:px-8">
    <div class="flex justify-between items-center mb-4 sm:mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow">Dashboard</h1>
        <div class="text-right">
            <div id="digital-clock" class="text-lg sm:text-xl md:text-2xl font-bold text-white font-mono"></div>
            <div id="digital-date" class="text-xs sm:text-sm text-gray-300"></div>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6 sm:mb-8">
        <!-- Stats Cards -->
        <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-3 sm:p-4 md:p-5 border border-gray-700/40 flex items-center justify-between transform hover:scale-105 transition-all duration-300">
            <div>
                <h2 class="text-sm sm:text-lg font-semibold text-gray-300">Total Goals</h2>
                <p class="text-2xl sm:text-3xl font-bold text-white">{{ $totalGoals }}</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-pink-500/20 to-pink-700/20 rounded-full flex items-center justify-center border border-pink-500/30">
                <i class="fas fa-bullseye text-xl sm:text-2xl text-pink-400"></i>
            </div>
        </div>

        <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-3 sm:p-4 md:p-5 border border-gray-700/40 flex items-center justify-between transform hover:scale-105 transition-all duration-300">
            <div>
                <h2 class="text-sm sm:text-lg font-semibold text-gray-300">Completed Goals</h2>
                <p class="text-2xl sm:text-3xl font-bold text-white">{{ $completedGoals }}</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-green-500/20 to-green-700/20 rounded-full flex items-center justify-center border border-green-500/30">
                <i class="fas fa-check-circle text-xl sm:text-2xl text-green-400"></i>
            </div>
        </div>

        <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-3 sm:p-4 md:p-5 border border-gray-700/40 flex items-center justify-between transform hover:scale-105 transition-all duration-300">
            <div>
                <h2 class="text-sm sm:text-lg font-semibold text-gray-300">Total Tasks</h2>
                <p class="text-2xl sm:text-3xl font-bold text-white">{{ $totalTasks }}</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500/20 to-blue-700/20 rounded-full flex items-center justify-center border border-blue-500/30">
                <i class="fas fa-tasks text-xl sm:text-2xl text-blue-400"></i>
            </div>
        </div>

        <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-3 sm:p-4 md:p-5 border border-gray-700/40 flex items-center justify-between transform hover:scale-105 transition-all duration-300">
            <div>
                <h2 class="text-sm sm:text-lg font-semibold text-gray-300">Completed Tasks</h2>
                <p class="text-2xl sm:text-3xl font-bold text-white">{{ $completedTasks }}</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-purple-500/20 to-purple-700/20 rounded-full flex items-center justify-center border border-purple-500/30">
                <i class="fas fa-clipboard-check text-xl sm:text-2xl text-purple-400"></i>
            </div>
        </div>
    </div>

    <!-- Calendar Section -->
    <div class="mt-6 sm:mt-8 mb-8 bg-gray-900/40 backdrop-blur-sm rounded-2xl sm:rounded-3xl shadow-2xl overflow-hidden border border-gray-700/40">
        <!-- Calendar Header -->
        <div class="bg-gradient-to-l from-gray-900/40 to-gray-900/50 backdrop-blur-sm p-3 sm:p-4 md:p-6 border-b border-gray-700/40">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
                <div class="flex items-center space-x-2 sm:space-x-3 md:space-x-5">
                    <div class="p-2 sm:p-3 lg:p-4 bg-gradient-to-r from-pink-500 to-pink-600 rounded-xl sm:rounded-2xl shadow-lg">
                        <i class="fas fa-calendar-alt text-white text-lg sm:text-xl md:text-2xl lg:text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent">Monthly Calendar</h2>
                        <p class="text-gray-300 text-xs sm:text-sm md:text-base lg:text-lg">View your tasks and goals for {{ $currentDate->format('F Y') }}</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-4 mt-3 sm:mt-0">
                    <a href="{{ route('goals.calendar', ['year' => $currentDate->year, 'month' => $currentDate->month]) }}" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-semibold py-2 sm:py-2.5 px-4 sm:px-6 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300 text-center flex items-center text-xs sm:text-sm" onclick="showLoading('Memuat calendar view...', 'Mohon tunggu sebentar')">
                        <i class="fas fa-external-link-alt mr-1 sm:mr-2"></i> <span class="hidden sm:inline">Show more in Calendar</span><span class="sm:hidden">Calendar</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Calendar Grid -->
        <div class="bg-gray-900/30 backdrop-blur-sm">
            <!-- Weekday Headers -->
            <div class="grid grid-cols-7 bg-gradient-to-l from-gray-900/30 to-gray-900/40 backdrop-blur-sm border-b border-gray-700/40">
                @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                    <div class="p-1 sm:p-2 md:p-3 lg:p-4 text-center">
                        <span class="text-xs font-bold text-gray-300 uppercase tracking-wider">{{ $dayName }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Calendar Days -->
            <div class="grid grid-cols-7">
                @foreach($calendarDays as $day)
                    @php
                        $dateKey = $day['date']->format('Y-m-d');
                        $events = $eventsByDate[$dateKey] ?? [];
                        $eventsCollection = collect($events);
                        $taskEvents = $eventsCollection->where('type', 'task');
                        $goalEvents = $eventsCollection->where('type', 'goal');
                    @endphp
                    
                    <div class="calendar-day min-h-[60px] sm:min-h-[80px] md:min-h-[100px] lg:min-h-[120px] xl:min-h-[140px] border-r border-b border-gray-600/50 p-1 sm:p-2 md:p-3 {{ $day['isCurrentMonth'] ? 'bg-gray-800/40' : 'bg-gray-900/40' }} {{ $day['isToday'] ? 'bg-gradient-to-br from-pink-900/40 to-pink-800/40 border-pink-500/30' : '' }} {{ $day['isWeekend'] ? 'bg-gray-900/40' : '' }} hover:bg-gray-700/40 transition-all duration-300 group {{ ($taskEvents->count() > 0 || $goalEvents->count() > 0) ? 'cursor-pointer' : '' }}"
                         @if($taskEvents->count() > 0 || $goalEvents->count() > 0)
                         onclick="showDateDetails('{{ $day['date']->format('Y-m-d') }}', '{{ $day['date']->format('l, F j, Y') }}')"
                         @endif>
                        
                        <!-- Date Number -->
                        <div class="flex justify-between items-start mb-1">
                            <span class="text-xs font-bold {{ $day['isCurrentMonth'] ? 'text-white' : 'text-gray-500' }} {{ $day['isToday'] ? 'bg-gradient-to-r from-pink-500 to-pink-600 text-white rounded-full w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 lg:w-8 lg:h-8 flex items-center justify-center shadow-lg' : '' }} group-hover:scale-110 transition-transform duration-200">
                                {{ $day['date']->format('j') }}
                            </span>
                            @if($day['isToday'])
                                <span class="text-xs text-pink-300 font-bold bg-pink-900/30 px-1 py-0.5 rounded-full border border-pink-500/20">TODAY</span>
                            @endif
                        </div>

                        <!-- Task Events Only -->
                        <div class="space-y-0.5 sm:space-y-1">
                            @foreach($taskEvents->take(1) as $event)
                                <div class="group/event relative">
                                    <div class="flex items-center p-1 sm:p-2 md:p-2.5 rounded-lg sm:rounded-xl text-xs hover:bg-gray-700/40 hover:shadow-lg transition-all duration-300 transform hover:scale-105 backdrop-blur-sm border border-gray-700/30"
                                         style="background: linear-gradient(135deg, {{ $event['color'] }}18 0%, {{ $event['color'] }}0F 50%, transparent 100%);"
                                         data-priority="{{ $event['priority'] }}" 
                                         data-status="{{ $event['status'] }}" 
                                         data-category="{{ $event['task']->goal->category->id ?? '' }}">
                                        
                                        <!-- Enhanced Task Icon -->
                                        <div class="flex-shrink-0 w-3 h-3 sm:w-4 sm:h-4 md:w-5 md:h-5 rounded-lg mr-1 sm:mr-2 flex items-center justify-center transition-all duration-300 group-hover/event:scale-110
                                            @if($event['status'] === 'completed')
                                                bg-gradient-to-br from-green-400 to-green-600 shadow-sm shadow-green-500/30
                                            @elseif($event['status'] === 'in_progress')
                                                bg-gradient-to-br from-blue-400 to-blue-600 shadow-sm shadow-blue-500/30 animate-pulse
                                            @else
                                                bg-gradient-to-br from-yellow-400 to-orange-500 shadow-sm shadow-yellow-500/30
                                            @endif">
                                            
                                            @if($event['status'] === 'completed')
                                                <i class="fas fa-check text-xs text-white"></i>
                                            @elseif($event['status'] === 'in_progress')
                                                <i class="fas fa-play text-xs text-white ml-0.5"></i>
                                            @else
                                                <i class="fas fa-clock text-xs text-white"></i>
                                            @endif
                                        </div>
                                        
                                        <!-- Task title - hidden on mobile, shown on desktop -->
                                        <span class="font-semibold text-gray-200 truncate text-xs flex-1 hidden sm:block">{{ $event['title'] }}</span>
                                        
                                        <!-- Priority Indicator -->
                                        @if($event['priority'] === 'high')
                                        <div class="flex-shrink-0 w-2 h-2 sm:w-3 sm:h-3 md:w-4 md:h-4 rounded-full bg-red-500 border border-white shadow-sm flex items-center justify-center ml-1">
                                                <i class="fas fa-exclamation-triangle text-[4px] sm:text-[5px] md:text-[8px] text-white"></i>
                                            </div>
                                        @elseif($event['priority'] === 'medium')
                                            <div class="flex-shrink-0 w-2 h-2 sm:w-3 sm:h-3 md:w-4 md:h-4 rounded-full bg-yellow-500 border border-white shadow-sm flex items-center justify-center ml-1">
                                                <i class="fas fa-minus text-[4px] sm:text-[5px] md:text-[8px] text-white"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            <!-- More Tasks Indicator -->
                            @if($taskEvents->count() > 1)
                                <div class="text-xs text-gray-300 text-center py-0.5 sm:py-1 md:py-1.5 bg-gray-800/30 rounded-lg font-medium backdrop-blur-sm border border-gray-700/30 hover:bg-gray-700/40 transition-colors duration-200">
                                    <i class="fas fa-plus mr-1"></i><span class="hidden sm:inline">{{ $taskEvents->count() - 1 }} more...</span><span class="sm:hidden">{{ $taskEvents->count() - 1 }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-8">
        <!-- Categories Section -->
        <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-3 sm:p-4 md:p-5 border border-gray-700/40 flex flex-col h-[300px] sm:h-[350px] md:h-[400px] transition-all duration-300">
            <div class="flex justify-between items-center mb-4 flex-shrink-0">
                <h2 class="text-lg sm:text-xl font-semibold text-white">Your Categories</h2>
                <a href="{{ route('categories.create') }}" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm font-semibold shadow-lg transform hover:scale-105 transition-all duration-300" onclick="showLoading('Memuat halaman...', 'Mohon tunggu sebentar')">Add New</a>
            </div>

            @if($categories->count() > 0)
                <div class="flex-1 overflow-y-auto modal-scrollbar space-y-2 sm:space-y-3 pr-2">
                    @foreach($categories as $category)
                        <div class="flex items-center p-2 sm:p-3 border rounded-lg border-gray-700/40 transition-all duration-200 transform hover:scale-[1.02] hover:shadow-lg backdrop-blur-sm hover:bg-gray-800/30" style="border-left-color: {{ $category->color }}; border-left-width: 4px;">
                            <div class="flex-1">
                                <h3 class="font-medium text-white text-sm sm:text-base">{{ $category->name }}</h3>
                                <p class="text-xs sm:text-sm text-gray-300">{{ $category->goals->count() }} goals</p>
                            </div>
                            <a href="{{ route('categories.show', $category->id) }}" class="text-pink-400 hover:text-pink-300 p-1.5 sm:p-2 hover:bg-gray-600/50 rounded-lg transition-all duration-200" onclick="showLoading('Memuat detail...', 'Mohon tunggu sebentar')">
                                <i class="fas fa-external-link-alt text-sm"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex-1 flex items-center justify-center">
                    <div class="text-center">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto mb-3 sm:mb-4 bg-gradient-to-br from-pink-500/20 to-pink-700/20 rounded-full flex items-center justify-center border border-pink-500/30">
                            <i class="fas fa-folder-open text-xl sm:text-2xl text-pink-400"></i>
                        </div>
                        <p class="text-gray-300 text-xs sm:text-sm px-2">No categories yet. Create your first category to organize your goals.</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Upcoming Goals Section -->
        <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-3 sm:p-4 md:p-5 border border-gray-700/40 flex flex-col h-[300px] sm:h-[350px] md:h-[400px] transition-all duration-300">
            <div class="flex justify-between items-center mb-4 flex-shrink-0">
                <h2 class="text-lg sm:text-xl font-semibold text-white">Upcoming Goals</h2>
                <a href="{{ route('goals.create') }}" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm font-semibold shadow-lg transform hover:scale-105 transition-all duration-300" onclick="showLoading('Memuat halaman...', 'Mohon tunggu sebentar')">Add New</a>
            </div>

            @if($upcomingGoals->count() > 0)
                <div class="flex-1 overflow-y-auto modal-scrollbar space-y-2 sm:space-y-3 pr-2">
                    @foreach($upcomingGoals as $goal)
                        <div class="p-2 sm:p-3 border rounded-lg border-gray-700/40 transition-all duration-200 transform hover:scale-[1.02] hover:shadow-lg backdrop-blur-sm bg-gray-800/20 hover:bg-gray-800/30">
                            <div class="flex justify-between items-start mb-2 sm:mb-3">
                                <h3 class="font-medium text-white flex-1 mr-2 sm:mr-3 text-sm sm:text-base">{{ $goal->title }}</h3>
                                <span class="text-xs sm:text-sm px-1.5 sm:px-2 py-0.5 sm:py-1 rounded-full {{ $goal->status === 'completed' ? 'bg-green-500/20 text-green-300 border border-green-500/30' : 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30' }} flex-shrink-0">
                                    {{ ucfirst($goal->formatted_status) }}
                                </span>
                            </div>
                            <div class="mb-2 sm:mb-3">
                                <div class="w-full bg-gray-700/50 rounded-full h-2 sm:h-2.5 overflow-hidden">
                                    <div class="bg-gradient-to-r from-pink-500 to-pink-600 h-2 sm:h-2.5 rounded-full transition-all duration-500" style="width: {{ $goal->progress_percent }}%;"></div>
                                </div>
                                <div class="flex justify-between mt-1 sm:mt-2">
                                    <span class="text-xs text-gray-300">{{ $goal->progress_percent }}% complete</span>
                                    <span class="text-xs text-gray-300">{{ $goal->end_date ? 'Due ' . $goal->end_date->format('M d, Y') : 'No end date' }}</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <a href="{{ route('goals.show', $goal->id) }}" class="text-xs sm:text-sm text-pink-400 hover:text-pink-300 flex items-center" onclick="showLoading('Memuat detail...', 'Mohon tunggu sebentar')">
                                    <i class="fas fa-eye mr-1"></i> View Details
                                </a>
                                @if($goal->category)
                                    <span class="text-xs text-gray-400 px-1.5 sm:px-2 py-0.5 sm:py-1 rounded-full bg-gray-600/30" style="border-left-color: {{ $goal->category->color }}; border-left-width: 3px;">
                                        {{ $goal->category->name }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex-1 flex items-center justify-center">
                    <div class="text-center">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto mb-3 sm:mb-4 bg-gradient-to-br from-blue-500/20 to-blue-700/20 rounded-full flex items-center justify-center border border-blue-500/30">
                            <i class="fas fa-bullseye text-xl sm:text-2xl text-blue-400"></i>
                        </div>
                        <p class="text-gray-300 text-xs sm:text-sm px-2">No upcoming goals. Create your first goal to start tracking your progress.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Tasks Section -->
    <div class="mt-6 sm:mt-8 mb-8 bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg p-3 sm:p-4 md:p-5 border border-gray-700/40 transition-all duration-300">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg sm:text-xl font-semibold text-white">Recent Tasks</h2>
            <a href="{{ route('tasks.create') }}" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm font-semibold shadow-lg transform hover:scale-105 transition-all duration-300" onclick="showLoading('Memuat halaman...', 'Mohon tunggu sebentar')">Add New</a>
        </div>

        @if($recentTasks->count() > 0)
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700 text-xs sm:text-sm">
                    <thead class="bg-gray-900">
                        <tr>
                            <th scope="col" class="px-2 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Task</th>
                            <th scope="col" class="px-2 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider hidden sm:table-cell">Goal</th>
                            <th scope="col" class="px-2 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider hidden md:table-cell">Due Date</th>
                            <th scope="col" class="px-2 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-2 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider hidden sm:table-cell">Priority</th>
                            <th scope="col" class="px-2 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800 divide-y divide-gray-700">
                        @foreach($recentTasks as $task)
                            <tr class="hover:bg-gray-700 transition-colors duration-200">
                                <td class="px-2 sm:px-6 py-2 sm:py-4 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm font-medium text-white">{{ $task->title }}</div>
                                </td>
                                <td class="px-2 sm:px-6 py-2 sm:py-4 whitespace-nowrap hidden sm:table-cell">
                                    <div class="text-xs sm:text-sm text-gray-400">{{ $task->goal->title ?? 'No Goal' }}</div>
                                </td>
                                <td class="px-2 sm:px-6 py-2 sm:py-4 whitespace-nowrap hidden md:table-cell">
                                    <div class="text-xs sm:text-sm text-gray-400">{{ $task->due_date ? $task->due_date->format('M d, Y') : 'No due date' }}</div>
                                </td>
                                <td class="px-2 sm:px-6 py-2 sm:py-4 whitespace-nowrap">
                                    <span class="px-1 sm:px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $task->status === 'completed' ? 'bg-green-500 text-white' : ($task->status === 'in_progress' ? 'bg-blue-500 text-white' : 'bg-yellow-500 text-white') }}">
                                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                    </span>
                                </td>
                                <td class="px-2 sm:px-6 py-2 sm:py-4 whitespace-nowrap hidden sm:table-cell">
                                    <span class="px-1 sm:px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $task->priority === 'high' ? 'bg-red-500 text-white' : ($task->priority === 'medium' ? 'bg-yellow-500 text-white' : 'bg-green-500 text-white') }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </td>
                                <td class="px-2 sm:px-6 py-2 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-medium">
                                    <a href="{{ route('tasks.show', $task->id) }}" class="text-pink-500 hover:text-pink-400" onclick="showLoading('Memuat detail...', 'Mohon tunggu sebentar')">View</a>                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-purple-500/20 to-purple-700/20 rounded-full flex items-center justify-center border border-purple-500/30">
                    <i class="fas fa-tasks text-2xl text-purple-400"></i>
                </div>
                <p class="text-gray-300 text-sm">No tasks yet. Create your first task to start tracking your progress.</p>
            </div>
        @endif
    </div>

    <!-- Date Detail Modal -->
    <div id="dateModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 z-[9999] flex items-center justify-center p-2 sm:p-4 lg:p-6 overflow-hidden backdrop-blur-sm">
        <div class="bg-gray-800/95 backdrop-blur-md rounded-xl sm:rounded-2xl lg:rounded-3xl shadow-2xl max-w-4xl w-full max-h-[95vh] sm:max-h-[90vh] lg:max-h-[85vh] flex flex-col border border-gray-600/50 transform transition-all duration-300 scale-95 opacity-0 calendar-modal-content" id="modalContent">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-gray-800/90 to-gray-700/90 backdrop-blur-sm p-3 sm:p-4 lg:p-6 rounded-t-xl sm:rounded-t-2xl lg:rounded-t-3xl border-b border-gray-600/50 flex-shrink-0">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-2 sm:space-x-3 lg:space-x-4">
                        <div class="p-1.5 sm:p-2 lg:p-3 bg-gradient-to-r from-pink-500 to-pink-600 rounded-lg sm:rounded-xl shadow-lg">
                            <i class="fas fa-calendar-day text-white text-sm sm:text-lg lg:text-xl"></i>
                        </div>
                        <div>
                            <h2 id="modalDate" class="text-base sm:text-lg lg:text-xl xl:text-2xl font-bold bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent"></h2>
                            <p class="text-gray-400 text-xs sm:text-sm">View your daily activities</p>
                        </div>
                    </div>
                    <button onclick="closeDateModal()" class="text-gray-400 hover:text-white text-lg sm:text-xl lg:text-2xl p-1.5 sm:p-2 hover:bg-gray-700 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-110">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Content -->
            <div class="flex-1 p-3 sm:p-4 lg:p-6 calendar-modal-mobile">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-4 lg:gap-6 h-full">
                    <!-- Tasks Section -->
                    <div class="bg-gray-700/50 backdrop-blur-sm rounded-lg sm:rounded-xl lg:rounded-2xl border border-gray-600/30 flex flex-col">
                        <div class="flex items-center justify-between p-3 sm:p-4 lg:p-6 border-b border-gray-600/30 flex-shrink-0">
                            <h3 class="text-base sm:text-lg lg:text-xl font-bold text-white flex items-center">
                                <div class="p-1.5 sm:p-2 bg-gradient-to-r from-green-500 to-green-600 rounded-lg mr-2 sm:mr-3 shadow-lg">
                                    <i class="fas fa-tasks text-white text-sm sm:text-base"></i>
                                </div>
                                Tasks
                            </h3>
                            <span id="taskCount" class="bg-green-500/20 text-green-300 px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-semibold border border-green-500/30">0</span>
                        </div>
                        <div id="tasksList" class="flex-1 overflow-y-auto p-3 sm:p-4 lg:p-6 space-y-2 sm:space-y-3 lg:space-y-4 modal-scrollbar">
                            <!-- Tasks will be populated here -->
                        </div>
                    </div>
                    
                    <!-- Goals Section -->
                    <div class="bg-gray-700/50 backdrop-blur-sm rounded-lg sm:rounded-xl lg:rounded-2xl border border-gray-600/30 flex flex-col">
                        <div class="flex items-center justify-between p-3 sm:p-4 lg:p-6 border-b border-gray-600/30 flex-shrink-0">
                            <h3 class="text-base sm:text-lg lg:text-xl font-bold text-white flex items-center">
                                <div class="p-1.5 sm:p-2 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg mr-2 sm:mr-3 shadow-lg">
                                    <i class="fas fa-bullseye text-white text-sm sm:text-base"></i>
                                </div>
                                Goals
                            </h3>
                            <span id="goalCount" class="bg-blue-500/20 text-blue-300 px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-semibold border border-blue-500/30">0</span>
                        </div>
                        <div id="goalsList" class="flex-1 overflow-y-auto p-3 sm:p-4 lg:p-6 space-y-2 sm:space-y-3 lg:space-y-4 modal-scrollbar">
                            <!-- Goals will be populated here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
// Calendar Functions
function showDateDetails(dateKey, dateString) {
    mountDateModal();
    // Get the modal
    const modal = document.getElementById('dateModal');
    if (!modal) {
        alert('Modal not found!');
        return;
    }

    // Disable body scroll when modal is open
    document.body.classList.add('modal-open');

    // Update modal title
    const modalDate = document.getElementById('modalDate');
    if (modalDate) {
        modalDate.textContent = dateString;
    }

    // Prepare modal content placeholder and show modal immediately
    const tasksListEl = document.getElementById('tasksList');
    const goalsListEl = document.getElementById('goalsList');
    const taskCountEl = document.getElementById('taskCount');
    const goalCountEl = document.getElementById('goalCount');
    if (taskCountEl) taskCountEl.textContent = '0';
    if (goalCountEl) goalCountEl.textContent = '0';
    if (tasksListEl) tasksListEl.innerHTML = '<div class="modal-loading"></div>';
    if (goalsListEl) goalsListEl.innerHTML = '<div class="modal-loading"></div>';

    // Show modal now
    // Force display using inline styles to avoid Tailwind conflicting classes
    modal.classList.remove('hidden');
    // Hard enforce inline styles to bypass Tailwind conflicts
    modal.style.position = 'fixed';
    modal.style.top = '0';
    modal.style.left = '0';
    modal.style.right = '0';
    modal.style.bottom = '0';
    modal.style.display = 'flex';
    modal.style.visibility = 'visible';
    modal.style.zIndex = '999999';
    modal.style.backgroundColor = 'rgba(0,0,0,0.75)';
    modal.style.alignItems = 'center';
    modal.style.justifyContent = 'center';
    // Backdrop fade-in
    modal.style.transition = 'opacity 250ms ease';
    modal.style.opacity = '0';

    // Animate modal content in
    setTimeout(() => {
        // Backdrop animate in
        modal.style.opacity = '1';
        const modalContent = document.getElementById('modalContent');
        if (modalContent) {
            // Content spring-like entrance
            modalContent.style.transition = 'opacity 320ms ease, transform 360ms cubic-bezier(0.22, 1, 0.36, 1), box-shadow 360ms ease';
            modalContent.style.opacity = '0';
            modalContent.style.transform = 'scale(0.96) translateY(12px)';
            modalContent.style.boxShadow = '0 20px 40px rgba(0,0,0,0.35)';
            requestAnimationFrame(() => {
                modalContent.style.opacity = '1';
                modalContent.style.transform = 'scale(1) translateY(0)';
            });
        }
    }, 10);

    // Fetch tasks and goals for this date from the server
    fetch(`/dashboard/calendar/details?date=${dateKey}`)
        .then(response => response.json())
        .then(data => {
            // Update counts
            // Update counts
            const taskCount = document.getElementById('taskCount');
            const goalCount = document.getElementById('goalCount');
            if (taskCount) taskCount.textContent = data.tasks.length;
            if (goalCount) goalCount.textContent = data.goals.length;
            
            // Populate tasks
            const tasksList = document.getElementById('tasksList');
            if (tasksList) {
                tasksList.innerHTML = '';
                if (data.tasks.length === 0) {
                    tasksList.innerHTML = '<div class="flex items-center justify-center h-full min-h-[120px] sm:min-h-[150px] md:min-h-[200px]"><p class="text-gray-400 text-center text-xs sm:text-sm md:text-base">No tasks scheduled for this date</p></div>';
                } else {
                    data.tasks.forEach(task => {
                        const taskElement = document.createElement('div');
                        taskElement.className = 'bg-gray-600/50 backdrop-blur-sm border border-gray-500/30 rounded-lg sm:rounded-xl p-3 sm:p-4 hover:bg-gray-600/70 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1';
                        taskElement.innerHTML = `
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 sm:space-x-4 mb-3">
                                        <!-- Enhanced Task Icon -->
                                        <div class="flex-shrink-0 w-6 h-6 sm:w-8 sm:h-8 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110
                                            ${task.status === 'completed' 
                                                ? 'bg-gradient-to-br from-green-400 to-green-600 shadow-lg shadow-green-500/30' 
                                                : task.status === 'in_progress' 
                                                    ? 'bg-gradient-to-br from-blue-400 to-blue-600 shadow-lg shadow-blue-500/30 animate-pulse' 
                                                    : 'bg-gradient-to-br from-yellow-400 to-orange-500 shadow-lg shadow-yellow-500/30'}">
                                            
                                            ${task.status === 'completed' 
                                                ? '<i class="fas fa-check text-white text-sm"></i>' 
                                                : task.status === 'in_progress' 
                                                    ? '<i class="fas fa-play text-white text-sm ml-0.5"></i>' 
                                                    : '<i class="fas fa-clock text-white text-sm"></i>'}
                                        </div>
                                        <h4 class="font-semibold text-white text-sm sm:text-base lg:text-lg">${task.title}</h4>
                                    </div>
                                    <p class="text-xs sm:text-sm text-gray-300 mb-3 flex items-center">
                                        <i class="fas fa-bullseye text-pink-400 mr-2"></i>
                                        ${task.goal_title || 'No Goal'}
                                    </p>
                                    <div class="flex items-center space-x-2 sm:space-x-3">
                                        <span class="px-2 sm:px-3 py-1 text-xs font-medium rounded-full ${task.status === 'completed' ? 'bg-green-500/20 text-green-300 border border-green-500/30' : 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30'}">
                                            ${task.status.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase())}
                                        </span>
                                        <span class="px-2 sm:px-3 py-1 text-xs font-medium rounded-full ${task.priority === 'high' ? 'bg-red-500/20 text-red-300 border border-red-500/30' : (task.priority === 'medium' ? 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30' : 'bg-green-500/20 text-green-300 border border-green-500/30')}">
                                            ${task.priority.charAt(0).toUpperCase() + task.priority.slice(1)}
                                        </span>
                                    </div>
                                </div>
                                <a href="/tasks/${task.id}" class="text-gray-400 hover:text-pink-400 ml-2 sm:ml-4 p-1.5 sm:p-2 hover:bg-gray-500/30 rounded-lg transition-all duration-300 transform hover:scale-110" onclick="showLoading('Memuat detail task...', 'Mohon tunggu sebentar')">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        `;
                        tasksList.appendChild(taskElement);
                    });
                }
            }
            
            // Populate goals
            const goalsList = document.getElementById('goalsList');
            if (goalsList) {
                goalsList.innerHTML = '';
                if (data.goals.length === 0) {
                    goalsList.innerHTML = '<div class="flex items-center justify-center h-full min-h-[120px] sm:min-h-[150px] md:min-h-[200px]"><p class="text-gray-400 text-center text-xs sm:text-sm md:text-base">No goals active on this date</p></div>';
                } else {
                    data.goals.forEach(goal => {
                        const goalElement = document.createElement('div');
                        goalElement.className = 'bg-gray-600/50 backdrop-blur-sm border border-gray-500/30 rounded-lg sm:rounded-xl p-3 sm:p-4 hover:bg-gray-600/70 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1';
                        goalElement.innerHTML = `
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 sm:space-x-4 mb-3">
                                        <!-- Enhanced Goal Icon -->
                                        <div class="flex-shrink-0 w-6 h-6 sm:w-8 sm:h-8 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110
                                            ${goal.status === 'completed' 
                                                ? 'bg-gradient-to-br from-green-400 to-green-600 shadow-lg shadow-green-500/30' 
                                                : 'bg-gradient-to-br from-blue-400 to-blue-600 shadow-lg shadow-blue-500/30'}">
                                            
                                            <i class="fas fa-bullseye text-white text-sm"></i>
                                        </div>
                                        <h4 class="font-semibold text-white text-sm sm:text-base lg:text-lg">${goal.title}</h4>
                                    </div>
                                    <div class="mb-3">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-xs sm:text-sm text-gray-300 flex items-center">
                                                <i class="fas fa-chart-line text-blue-400 mr-2"></i>
                                                Progress
                                            </span>
                                            <span class="text-xs sm:text-sm font-semibold text-blue-300">${goal.progress_percent}%</span>
                                        </div>
                                        <div class="w-full bg-gray-500/30 rounded-full h-2 overflow-hidden">
                                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-500" style="width: ${goal.progress_percent}%"></div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2 sm:space-x-3">
                                        <span class="px-2 sm:px-3 py-1 text-xs font-medium rounded-full ${goal.status === 'completed' ? 'bg-green-500/20 text-green-300 border border-green-500/30' : 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30'}">
                                            ${goal.status.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase())}
                                        </span>
                                        <span class="px-2 sm:px-3 py-1 text-xs font-medium rounded-full ${goal.priority === 'high' ? 'bg-red-500/20 text-red-300 border border-red-500/30' : (goal.priority === 'medium' ? 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30' : 'bg-green-500/20 text-green-300 border border-green-500/30')}">
                                            ${goal.priority.charAt(0).toUpperCase() + goal.priority.slice(1)}
                                        </span>
                                    </div>
                                </div>
                                <a href="/goals/${goal.id}" class="text-gray-400 hover:text-blue-400 ml-2 sm:ml-4 p-1.5 sm:p-2 hover:bg-gray-500/30 rounded-lg transition-all duration-300 transform hover:scale-110" onclick="showLoading('Memuat detail goal...', 'Mohon tunggu sebentar')">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        `;
                        goalsList.appendChild(goalElement);
                    });
                }
            }
            
            // Ensure modal content sizes
            setTimeout(() => {
                const modalContent = document.getElementById('modalContent');
                // Set max height for scrollable content
                const tasksList = document.getElementById('tasksList');
                const goalsList = document.getElementById('goalsList');
                
                if (tasksList) {
                    if (window.innerWidth < 480) {
                        tasksList.style.maxHeight = '180px';
                    } else if (window.innerWidth < 640) {
                        tasksList.style.maxHeight = '220px';
                    } else if (window.innerWidth < 1024) {
                        tasksList.style.maxHeight = '300px';
                    } else {
                        tasksList.style.maxHeight = '350px';
                    }
                }
                if (goalsList) {
                    if (window.innerWidth < 480) {
                        goalsList.style.maxHeight = '180px';
                    } else if (window.innerWidth < 640) {
                        goalsList.style.maxHeight = '220px';
                    } else if (window.innerWidth < 1024) {
                        goalsList.style.maxHeight = '300px';
                    } else {
                        goalsList.style.maxHeight = '350px';
                    }
                }
            }, 10);
        })
        .catch(error => {
            console.error('Error fetching date details:', error);
            const tasksList = document.getElementById('tasksList');
            const goalsList = document.getElementById('goalsList');
            if (tasksList) tasksList.innerHTML = '<div class="text-center text-gray-400 py-6">Failed to load tasks.</div>';
            if (goalsList) goalsList.innerHTML = '<div class="text-center text-gray-400 py-6">Failed to load goals.</div>';
        });
}

// Move modal to body to avoid ancestor overflow/transform clipping issues
let __dateModalPrevParent = null;
let __dateModalNextSibling = null;
function mountDateModal() {
    const modal = document.getElementById('dateModal');
    if (!modal) return;
    if (modal.parentElement !== document.body) {
        __dateModalPrevParent = modal.parentElement;
        __dateModalNextSibling = modal.nextSibling;
        document.body.appendChild(modal);
    }
}

function restoreDateModal() {
    const modal = document.getElementById('dateModal');
    if (!modal) return;
    if (__dateModalPrevParent) {
        if (__dateModalNextSibling) {
            __dateModalPrevParent.insertBefore(modal, __dateModalNextSibling);
        } else {
            __dateModalPrevParent.appendChild(modal);
        }
        __dateModalPrevParent = null;
        __dateModalNextSibling = null;
    }
}

function closeDateModal() {
    const modal = document.getElementById('dateModal');
    const modalContent = document.getElementById('modalContent');
    
    if (modal && modalContent) {
        // Animate modal closing (content)
        modalContent.style.transition = modalContent.style.transition || 'opacity 280ms ease, transform 300ms cubic-bezier(0.22, 1, 0.36, 1)';
        modalContent.style.opacity = '0';
        modalContent.style.transform = 'scale(0.96) translateY(12px)';
        // Animate backdrop fade-out
        modal.style.transition = modal.style.transition || 'opacity 240ms ease';
        modal.style.opacity = '0';
        
        // Hide modal after animation
        setTimeout(() => {
            modal.style.display = 'none';
            modal.classList.add('hidden');
            modal.style.visibility = '';
            modal.style.opacity = '';
            
            // Re-enable body scroll when modal is closed
            document.body.classList.remove('modal-open');
            // Restore modal to original place if moved
            restoreDateModal();
        }, 300);
    }
}

</script>
<style>
    .swal2-icon.no-border {
        border: 0;
    }
    .animate__animated {
        --animate-duration: 0.4s;
    }
    /* Calendar Modal Responsive Styles */
    .modal-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #6B7280 #374151;
    }
    .modal-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .modal-scrollbar::-webkit-scrollbar-track {
        background: rgba(55, 65, 81, 0.3);
        border-radius: 8px;
        margin: 2px;
    }
    .modal-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #6B7280 0%, #9CA3AF 100%);
        border-radius: 8px;
        border: 1px solid rgba(55, 65, 81, 0.3);
        transition: all 0.3s ease;
    }
    .modal-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #9CA3AF 0%, #D1D5DB 100%);
        transform: scale(1.05);
    }
    .modal-scrollbar::-webkit-scrollbar-corner {
        background: transparent;
    }
    
    /* Dashboard Cards Responsive Styles */
    @media (max-width: 1024px) {
        .h-[400px] {
            height: 350px;
        }
    }
    @media (max-width: 768px) {
        .h-[400px] {
            height: 300px;
        }
    }
    @media (max-width: 640px) {
        .h-[400px] {
            height: 250px;
        }
    }
    #tasksList, #goalsList {
        min-height: 120px;
        max-height: 300px;
    }
    @media (max-width: 640px) {
        #tasksList, #goalsList {
            min-height: 100px;
            max-height: 250px;
        }
        #dateModal .grid {
            min-height: 250px;
        }
        .calendar-modal-mobile {
            padding: 0.5rem;
        }
    }
    @media (max-width: 480px) {
        #tasksList, #goalsList {
            min-height: 80px;
            max-height: 200px;
        }
        #dateModal .grid {
            min-height: 200px;
        }
        .calendar-day {
            min-height: 50px !important;
        }
        
        /* Table mobile optimizations */
        .overflow-x-auto {
            -webkit-overflow-scrolling: touch;
        }
        
        /* Ensure table cells don't wrap on mobile */
        .whitespace-nowrap {
            white-space: nowrap;
        }
        
        /* Mobile calendar day optimizations */
        .calendar-day {
            min-height: 50px !important;
        }
    }
    #dateModal .grid {
        min-height: 400px;
    }
    body.modal-open {
        overflow: hidden;
        position: fixed;
        width: 100%;
    }
    
    /* Mobile Calendar Modal Enhancements */
    @media (max-width: 640px) {
        #dateModal {
            padding: 0.5rem;
            align-items: center !important;
            justify-content: center !important;
        }
        
        /* Mobile table optimizations */
        .overflow-x-auto {
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        
        .overflow-x-auto::-webkit-scrollbar {
            display: none;
        }
        
        #dateModal .bg-gray-800\/95 {
            border-radius: 1rem;
        }
        
        #modalContent {
            max-height: 95vh;
            max-height: calc(var(--vh, 1vh) * 95);
            width: 98vw;
            margin: 0 auto;
            border-radius: 1rem;
        }
        
        .calendar-modal-mobile .grid {
            gap: 0.5rem;
        }
        
        .calendar-modal-mobile .bg-gray-700\/50 {
            border-radius: 0.75rem;
        }
        
        .calendar-modal-mobile .p-4 {
            padding: 0.75rem;
        }
        
        .calendar-modal-mobile .p-6 {
            padding: 1rem;
        }
        
        /* Mobile modal content optimizations */
        .calendar-modal-mobile .grid {
            gap: 0.5rem;
        }
        
        .calendar-modal-mobile .bg-gray-700\/50 {
            border-radius: 0.75rem;
        }
        
        /* Mobile modal header optimizations */
        .calendar-modal-mobile .p-4 {
            padding: 0.75rem;
        }
        
        .calendar-modal-mobile .p-6 {
            padding: 1rem;
        }
    }
    
    @media (max-width: 480px) {
        #dateModal {
            padding: 0.25rem;
            align-items: center !important;
            justify-content: center !important;
        }
        
        /* Ensure modal content is properly sized */
        #modalContent {
            max-height: 98vh;
            max-height: calc(var(--vh, 1vh) * 98);
            width: 95vw;
            margin: 0 auto;
            border-radius: 0.75rem;
        }
        
        #dateModal .bg-gray-800\/95 {
            border-radius: 0.75rem;
        }
        
        #modalContent {
            max-height: 98vh;
        }
        
        .calendar-modal-mobile .grid {
            gap: 0.25rem;
        }
        
        .calendar-modal-mobile .bg-gray-700\/50 {
            border-radius: 0.5rem;
        }
        
        .calendar-modal-mobile .p-4 {
            padding: 0.5rem;
        }
        
        .calendar-modal-mobile .p-6 {
            padding: 0.75rem;
        }
        
        /* Mobile modal content optimizations for smaller screens */
        .calendar-modal-mobile .grid {
            gap: 0.25rem;
        }
        
        .calendar-modal-mobile .bg-gray-700\/50 {
            border-radius: 0.5rem;
        }
        
        /* Ensure modal header is properly sized */
        .calendar-modal-mobile .p-4 {
            padding: 0.5rem;
        }
    }

    /* Enhanced Mobile Modal Optimizations */
    @media (max-width: 640px) {
        .calendar-modal-mobile .grid {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }
        
        .calendar-modal-mobile .bg-gray-700\/50 {
            min-height: 200px;
        }
        
        .calendar-modal-mobile h3 {
            font-size: 0.875rem;
        }
        
        .calendar-modal-mobile .text-xs {
            font-size: 0.75rem;
        }
    }

    @media (max-width: 480px) {
        .calendar-modal-mobile .grid {
            gap: 0.5rem;
        }
        
        .calendar-modal-mobile .bg-gray-700\/50 {
            min-height: 150px;
        }
        
        .calendar-modal-mobile h3 {
            font-size: 0.8125rem;
        }
        
        .calendar-modal-mobile .text-xs {
            font-size: 0.6875rem;
        }
    }

    /* Modal Animation Improvements */
    .calendar-modal-content {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Ensure modal backdrop is properly positioned */
    #dateModal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 9999;
        align-items: center !important;
        justify-content: center !important;
    }

    /* Modal content positioning */
    .calendar-modal-content {
        transform-origin: center;
        margin: auto;
        max-width: 90vw;
        max-height: 90vh;
    }

    @media (max-width: 640px) {
        .calendar-modal-content {
            max-width: 95vw;
            max-height: 95vh;
            margin: 0.25rem;
        }
    }

    @media (max-width: 480px) {
        .calendar-modal-content {
            max-width: 98vw;
            max-height: 98vh;
            margin: 0.125rem;
        }
    }
    /* Mobile Calendar Grid Optimizations */
    @media (max-width: 640px) {
        .calendar-day {
            min-height: 50px !important;
            padding: 0.5rem !important;
        }
        
        .calendar-day .group\/event {
            margin-bottom: 0.25rem;
        }
        
        .calendar-day .group\/event:last-child {
            margin-bottom: 0;
        }
        
        /* Ensure icons are visible on mobile */
        .calendar-day .flex-shrink-0 {
            min-width: 1rem;
            min-height: 1rem;
        }
        
        /* Hide text elements on mobile */
        .calendar-day .hidden.sm\:block {
            display: none !important;
        }
        
        /* Show only icons on mobile */
        .calendar-day .flex.items-center {
            justify-content: center;
        }
        
        /* Priority indicators on mobile */
        .calendar-day .flex-shrink-0.w-2.h-2 {
            width: 0.75rem;
            height: 0.75rem;
        }
    }

    @media (max-width: 480px) {
        .calendar-day {
            min-height: 45px !important;
            padding: 0.375rem !important;
        }
        
        .calendar-day .flex-shrink-0 {
            min-width: 0.875rem;
            min-height: 0.875rem;
        }
        
        /* Even smaller priority indicators */
        .calendar-day .flex-shrink-0.w-2.h-2 {
            width: 0.625rem;
            height: 0.625rem;
        }
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('dateModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDateModal();
            }
        });
        modal.addEventListener('wheel', function(e) {
            if (e.target === this) {
                e.preventDefault();
            }
        }, { passive: false });
        modal.addEventListener('touchmove', function(e) {
            if (e.target === this) {
                e.preventDefault();
            }
        }, { passive: false });
        
        // Mobile-specific modal handling
        const modalContent = document.getElementById('modalContent');
        if (modalContent) {
            modalContent.addEventListener('touchmove', function(e) {
                e.stopPropagation();
            }, { passive: false });
        }
        
        // Prevent body scroll when modal is open on mobile
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                    const modal = document.getElementById('dateModal');
                    if (modal && !modal.classList.contains('hidden')) {
                        document.body.classList.add('modal-open');
                    } else {
                        document.body.classList.remove('modal-open');
                    }
                }
            });
        });
        
        observer.observe(modal, { attributes: true });
    }
    
    // Handle mobile viewport height issues
    function setMobileViewportHeight() {
        const vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);
    }
    
    setMobileViewportHeight();
    window.addEventListener('resize', setMobileViewportHeight);
    window.addEventListener('orientationchange', setMobileViewportHeight);
    
    // Handle mobile modal positioning
    function handleMobileModal() {
        const modal = document.getElementById('dateModal');
        if (modal) {
            // Always center the modal regardless of screen size
            modal.style.alignItems = 'center';
            modal.style.justifyContent = 'center';
            modal.style.paddingTop = '0';
        }
    }
    
    handleMobileModal();
    window.addEventListener('resize', handleMobileModal);
    
    // Digital Clock Function
    function updateDigitalClock() {
        const now = new Date();
        
        // Format time (HH:MM:SS)
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const timeString = `${hours}:${minutes}:${seconds}`;
        
        // Format date
        const options = { 
            weekday: 'short', 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric' 
        };
        const dateString = now.toLocaleDateString('en-US', options);
        
        // Update DOM elements
        const clockElement = document.getElementById('digital-clock');
        const dateElement = document.getElementById('digital-date');
        
        if (clockElement) {
            clockElement.textContent = timeString;
        }
        
        if (dateElement) {
            dateElement.textContent = dateString;
        }
    }
    
    // Initialize clock and update every second
    updateDigitalClock();
    setInterval(updateDigitalClock, 1000);
});
</script>