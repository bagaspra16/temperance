@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-900">
    <div class="container mx-auto px-3 sm:px-4 py-4 sm:py-6 lg:py-8">
        <!-- Enhanced Header with Filters -->
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-3xl shadow-2xl p-4 sm:p-6 lg:p-8 mb-6 sm:mb-8 border border-gray-600/50">
            <div class="flex flex-col space-y-4 lg:space-y-0 lg:flex-row lg:justify-between lg:items-center">
                <!-- Title and Navigation Section -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 lg:space-x-8">
                    <div class="flex items-center space-x-3 sm:space-x-5">
                        <div class="p-2 sm:p-3 lg:p-4 bg-gradient-to-r from-pink-500 to-pink-600 rounded-xl sm:rounded-2xl shadow-lg">
                            <i class="fas fa-calendar-alt text-white text-xl sm:text-2xl lg:text-3xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent">Calendar View</h1>
                            <p class="text-gray-300 text-sm sm:text-base lg:text-lg">Manage your tasks and goals efficiently</p>
                        </div>
                    </div>
                    
                    <!-- Month Navigation -->
                    <div class="flex items-center space-x-2 sm:space-x-3 bg-gray-700/50 backdrop-blur-sm rounded-xl sm:rounded-2xl p-2 sm:p-3 border border-gray-600/30">
                        <a href="{{ route('goals.calendar', ['year' => $previousMonth->year, 'month' => $previousMonth->month]) }}" 
                           class="p-2 sm:p-3 hover:bg-gray-600/50 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-110">
                            <i class="fas fa-chevron-left text-gray-300 text-base sm:text-lg"></i>
                        </a>
                        <span class="text-lg sm:text-xl lg:text-2xl font-bold text-white px-3 sm:px-6 min-w-[100px] sm:min-w-[140px] text-center">
                            {{ $currentDate->format('F Y') }}
                        </span>
                        <a href="{{ route('goals.calendar', ['year' => $nextMonth->year, 'month' => $nextMonth->month]) }}" 
                           class="p-2 sm:p-3 hover:bg-gray-600/50 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-110">
                            <i class="fas fa-chevron-right text-gray-300 text-base sm:text-lg"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-3 lg:space-x-4">
                    <a href="{{ route('goals.calendar') }}" class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white font-semibold py-3 sm:py-4 px-6 sm:px-8 rounded-xl sm:rounded-2xl shadow-lg transform hover:scale-105 transition-all duration-300 text-center">
                        <i class="fas fa-calendar-day mr-2 sm:mr-3"></i> Today
                    </a>
                    <a href="{{ route('goals.create') }}" class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white font-semibold py-3 sm:py-4 px-6 sm:px-8 rounded-xl sm:rounded-2xl shadow-lg transform hover:scale-105 transition-all duration-300 text-center">
                        <i class="fas fa-plus mr-2 sm:mr-3"></i> Add Goal
                    </a>
                </div>
            </div>
            
            <!-- Advanced Filters -->
            <div class="mt-6 sm:mt-8 pt-6 sm:pt-8 border-t border-gray-600/50">
                <div class="flex flex-col sm:flex-row flex-wrap items-start sm:items-center gap-4 sm:gap-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gray-700/50 rounded-lg">
                            <i class="fas fa-filter text-pink-400"></i>
                        </div>
                        <span class="text-base sm:text-lg font-semibold text-gray-300">Filter by:</span>
                    </div>
                    
                    <!-- Priority Filter -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-1 sm:space-y-0 sm:space-x-3 w-full sm:w-auto">
                        <label class="text-sm text-gray-400 font-medium">Priority:</label>
                        <select id="priorityFilter" class="w-full sm:w-auto bg-gray-700/50 backdrop-blur-sm border border-gray-600/30 rounded-xl px-3 sm:px-4 py-2 sm:py-3 text-sm text-white focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-300 hover:bg-gray-700/70">
                            <option value="">All Priorities</option>
                            <option value="high">High Priority</option>
                            <option value="medium">Medium Priority</option>
                            <option value="low">Low Priority</option>
                        </select>
                    </div>
                    
                    <!-- Status Filter -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-1 sm:space-y-0 sm:space-x-3 w-full sm:w-auto">
                        <label class="text-sm text-gray-400 font-medium">Status:</label>
                        <select id="statusFilter" class="w-full sm:w-auto bg-gray-700/50 backdrop-blur-sm border border-gray-600/30 rounded-xl px-3 sm:px-4 py-2 sm:py-3 text-sm text-white focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-300 hover:bg-gray-700/70">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    
                    <!-- Category Filter -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-1 sm:space-y-0 sm:space-x-3 w-full sm:w-auto">
                        <label class="text-sm text-gray-400 font-medium">Category:</label>
                        <select id="categoryFilter" class="w-full sm:w-auto bg-gray-700/50 backdrop-blur-sm border border-gray-600/30 rounded-xl px-3 sm:px-4 py-2 sm:py-3 text-sm text-white focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-300 hover:bg-gray-700/70">
                            <option value="">All Categories</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}" style="color: {{ $category->color }};">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Calendar Grid -->
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl sm:rounded-3xl shadow-2xl overflow-hidden border border-gray-600/50">
            <!-- Weekday Headers -->
            <div class="grid grid-cols-7 bg-gradient-to-r from-gray-700/90 to-gray-800/90 backdrop-blur-sm border-b border-gray-600/50">
                @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                    <div class="p-2 sm:p-3 lg:p-4 text-center">
                        <span class="text-xs sm:text-sm font-bold text-gray-300 uppercase tracking-wider">{{ $dayName }}</span>
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
                    
                    <div class="calendar-day min-h-[100px] sm:min-h-[120px] md:min-h-[140px] lg:min-h-[160px] border-r border-b border-gray-600/50 p-2 sm:p-3 {{ $day['isCurrentMonth'] ? 'bg-gray-800/50' : 'bg-gray-900/50' }} {{ $day['isToday'] ? 'bg-gradient-to-br from-pink-900/80 to-pink-800/80 border-pink-500/50' : '' }} {{ $day['isWeekend'] ? 'bg-gray-900/50' : '' }} hover:bg-gray-700/70 transition-all duration-300 group {{ ($taskEvents->count() > 0 || $goalEvents->count() > 0) ? 'cursor-pointer' : '' }}"
                         @if($taskEvents->count() > 0 || $goalEvents->count() > 0)
                         onclick="showDateDetails('{{ $day['date']->format('Y-m-d') }}', '{{ $day['date']->format('l, F j, Y') }}')"
                         @endif>
                        
                        <!-- Date Number -->
                        <div class="flex justify-between items-start mb-2 sm:mb-3">
                            <span class="text-xs sm:text-sm font-bold {{ $day['isCurrentMonth'] ? 'text-white' : 'text-gray-500' }} {{ $day['isToday'] ? 'bg-gradient-to-r from-pink-500 to-pink-600 text-white rounded-full w-6 h-6 sm:w-7 sm:h-7 lg:w-8 lg:h-8 flex items-center justify-center shadow-lg' : '' }} group-hover:scale-110 transition-transform duration-200">
                                {{ $day['date']->format('j') }}
                            </span>
                            @if($day['isToday'])
                                <span class="text-xs text-pink-300 font-bold bg-pink-900/50 px-1.5 sm:px-2 py-0.5 sm:py-1 rounded-full border border-pink-500/30">TODAY</span>
                            @endif
                        </div>

                        <!-- Task Events Only -->
                        <div class="space-y-1 sm:space-y-2">
                            @foreach($taskEvents->take(2) as $event)
                                <div class="group/event relative">
                                    <div class="flex items-center p-1.5 sm:p-2 rounded-lg sm:rounded-xl text-xs hover:bg-gray-600/50 hover:shadow-md transition-all duration-200 transform hover:scale-105 backdrop-blur-sm"
                                         style="border-left: 2px solid {{ $event['color'] }}; background: linear-gradient(90deg, {{ $event['color'] }}15 0%, transparent 100%);"
                                         data-priority="{{ $event['priority'] }}" 
                                         data-status="{{ $event['status'] }}" 
                                         data-category="{{ $event['task']->goal->category->id ?? '' }}">
                                        <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full mr-1.5 sm:mr-2 shadow-sm" style="background-color: {{ $event['color'] }};"></div>
                                        <span class="font-semibold text-gray-200 truncate text-xs">{{ $event['title'] }}</span>
                                        @if($event['priority'] === 'high')
                                            <i class="fas fa-exclamation-triangle text-red-400 ml-1 text-xs animate-pulse"></i>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            <!-- More Tasks Indicator -->
                            @if($taskEvents->count() > 2)
                                <div class="text-xs text-gray-400 text-center py-1 sm:py-1.5 bg-gray-700/50 rounded-lg font-medium backdrop-blur-sm border border-gray-600/30">
                                    {{ $taskEvents->count() - 2 }} more...
                                </div>
                            @endif
                            

                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Date Detail Modal -->
        <div id="dateModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-2 sm:p-4 overflow-hidden backdrop-blur-sm">
            <div class="bg-gray-800/95 backdrop-blur-md rounded-2xl sm:rounded-3xl shadow-2xl max-w-5xl w-full max-h-[90vh] sm:max-h-[85vh] flex flex-col border border-gray-600/50 transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-gray-800/90 to-gray-700/90 backdrop-blur-sm p-4 sm:p-6 rounded-t-2xl sm:rounded-t-3xl border-b border-gray-600/50 flex-shrink-0">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-3 sm:space-x-4">
                            <div class="p-2 sm:p-3 bg-gradient-to-r from-pink-500 to-pink-600 rounded-lg sm:rounded-xl shadow-lg">
                                <i class="fas fa-calendar-day text-white text-lg sm:text-xl"></i>
                            </div>
                            <div>
                                <h2 id="modalDate" class="text-lg sm:text-xl lg:text-2xl font-bold bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent"></h2>
                                <p class="text-gray-400 text-xs sm:text-sm">View your daily activities</p>
                            </div>
                        </div>
                        <button onclick="closeDateModal()" class="text-gray-400 hover:text-white text-xl sm:text-2xl p-2 hover:bg-gray-700 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-110">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Modal Content -->
                <div class="flex-1 p-4 sm:p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 lg:gap-8 h-full">
                        <!-- Tasks Section -->
                        <div class="bg-gray-700/50 backdrop-blur-sm rounded-xl sm:rounded-2xl border border-gray-600/30 flex flex-col">
                            <div class="flex items-center justify-between p-4 sm:p-6 border-b border-gray-600/30 flex-shrink-0">
                                <h3 class="text-lg sm:text-xl font-bold text-white flex items-center">
                                    <div class="p-2 bg-gradient-to-r from-green-500 to-green-600 rounded-lg mr-2 sm:mr-3 shadow-lg">
                                        <i class="fas fa-tasks text-white"></i>
                                    </div>
                                    Tasks
                                </h3>
                                <span id="taskCount" class="bg-green-500/20 text-green-300 px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-semibold border border-green-500/30">0</span>
                            </div>
                            <div id="tasksList" class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-3 sm:space-y-4 custom-scrollbar">
                                <!-- Tasks will be populated here -->
                            </div>
                        </div>
                        
                        <!-- Goals Section -->
                        <div class="bg-gray-700/50 backdrop-blur-sm rounded-xl sm:rounded-2xl border border-gray-600/30 flex flex-col">
                            <div class="flex items-center justify-between p-4 sm:p-6 border-b border-gray-600/30 flex-shrink-0">
                                <h3 class="text-lg sm:text-xl font-bold text-white flex items-center">
                                    <div class="p-2 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg mr-2 sm:mr-3 shadow-lg">
                                        <i class="fas fa-bullseye text-white"></i>
                                    </div>
                                    Goals
                                </h3>
                                <span id="goalCount" class="bg-blue-500/20 text-blue-300 px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-semibold border border-blue-500/30">0</span>
                            </div>
                            <div id="goalsList" class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-3 sm:space-y-4 custom-scrollbar">
                                <!-- Goals will be populated here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Information Section -->
        <div class="mt-6 sm:mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <!-- Monthly Overview Card -->
            <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl sm:rounded-2xl shadow-xl p-4 sm:p-6 text-white">
                <div class="flex items-center justify-between mb-3 sm:mb-4">
                    <h3 class="text-lg sm:text-xl font-bold">Monthly Overview</h3>
                    <i class="fas fa-chart-line text-2xl sm:text-3xl opacity-80"></i>
                </div>
                <div class="space-y-3 sm:space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-pink-100 text-sm sm:text-base">Total Tasks</span>
                        <span class="text-xl sm:text-2xl font-bold">{{ $tasks->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-pink-100 text-sm sm:text-base">Completed</span>
                        <span class="text-xl sm:text-2xl font-bold text-green-300">{{ $tasks->where('status', 'completed')->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-pink-100 text-sm sm:text-base">Pending</span>
                        <span class="text-xl sm:text-2xl font-bold text-yellow-300">{{ $tasks->where('status', '!=', 'completed')->count() }}</span>
                    </div>
                    <div class="w-full bg-pink-400 rounded-full h-2 mt-2">
                        <div class="bg-green-300 h-2 rounded-full" style="width: {{ $tasks->count() > 0 ? ($tasks->where('status', 'completed')->count() / $tasks->count()) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Priority Distribution -->
            <div class="bg-gradient-to-br from-gray-700 to-gray-800 rounded-xl sm:rounded-2xl shadow-xl p-4 sm:p-6 text-white">
                <div class="flex items-center justify-between mb-3 sm:mb-4">
                    <h3 class="text-lg sm:text-xl font-bold">Priority Distribution</h3>
                    <i class="fas fa-layer-group text-2xl sm:text-3xl opacity-80"></i>
                </div>
                <div class="space-y-3 sm:space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-300 text-sm sm:text-base">High Priority</span>
                        <span class="text-xl sm:text-2xl font-bold text-red-400">{{ $tasks->where('priority', 'high')->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-300 text-sm sm:text-base">Medium Priority</span>
                        <span class="text-xl sm:text-2xl font-bold text-yellow-400">{{ $tasks->where('priority', 'medium')->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-300 text-sm sm:text-base">Low Priority</span>
                        <span class="text-xl sm:text-2xl font-bold text-green-400">{{ $tasks->where('priority', 'low')->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-gray-700 to-gray-800 rounded-xl sm:rounded-2xl shadow-xl p-4 sm:p-6 text-white md:col-span-2 lg:col-span-1">
                <div class="flex items-center justify-between mb-3 sm:mb-4">
                    <h3 class="text-lg sm:text-xl font-bold">Quick Actions</h3>
                    <i class="fas fa-bolt text-2xl sm:text-3xl opacity-80"></i>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-1 gap-3">
                    <a href="{{ route('tasks.create') }}" class="bg-yellow-500 bg-opacity-10 hover:bg-opacity-20 rounded-lg p-3 text-center font-semibold transition-all duration-300 transform hover:scale-105 text-sm sm:text-base">
                        <i class="fas fa-plus mr-2"></i> Add New Task
                    </a>
                    <a href="{{ route('goals.create') }}" class="bg-green-500 bg-opacity-10 hover:bg-opacity-20 rounded-lg p-3 text-center font-semibold transition-all duration-300 transform hover:scale-105 text-sm sm:text-base">
                        <i class="fas fa-bullseye mr-2"></i> Create Goal
                    </a>
                    <a href="{{ route('progress.index') }}" class="bg-blue-500 bg-opacity-10 hover:bg-opacity-20 rounded-lg p-3 text-center font-semibold transition-all duration-300 transform hover:scale-105 text-sm sm:text-base">
                        <i class="fas fa-chart-bar mr-2"></i> Track Progress
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activity Feed -->
        <div class="mt-6 sm:mt-8 bg-gray-800 rounded-xl sm:rounded-2xl shadow-xl p-4 sm:p-6 border border-gray-700">
            <h3 class="text-xl sm:text-2xl font-bold text-white mb-4 sm:mb-6 flex items-center">
                <i class="fas fa-history text-pink-400 mr-2 sm:mr-3"></i>
                Recent Activity
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @foreach($recentTasks ?? [] as $task)
                    <div class="bg-gradient-to-r from-gray-700 to-gray-800 rounded-lg sm:rounded-xl p-3 sm:p-4 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-gray-600">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h4 class="font-semibold text-white mb-1 text-sm sm:text-base">{{ $task->title }}</h4>
                                <p class="text-xs sm:text-sm text-gray-400 mb-2">{{ $task->goal->title ?? 'No Goal' }}</p>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $task->status === 'completed' ? 'bg-green-900 text-green-300' : 'bg-yellow-900 text-yellow-300' }}">
                                        {{ ucfirst($task->status) }}
                                    </span>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $task->priority === 'high' ? 'bg-red-900 text-red-300' : ($task->priority === 'medium' ? 'bg-yellow-900 text-yellow-300' : 'bg-green-900 text-green-300') }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('tasks.show', $task->id) }}" class="text-pink-400 hover:text-pink-300 ml-2">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
// Simple Date Details Function
function showDateDetails(dateKey, dateString) {
    console.log('showDateDetails called for:', dateKey, dateString);
    
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
    
    // Get tasks and goals for this date from the server
    fetch(`/goals/calendar/details?date=${dateKey}`)
        .then(response => response.json())
        .then(data => {
            console.log('Received data:', data);
            
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
                    tasksList.innerHTML = '<div class="flex items-center justify-center h-full min-h-[150px] sm:min-h-[200px]"><p class="text-gray-400 text-center text-sm sm:text-base">No tasks scheduled for this date</p></div>';
                } else {
                    data.tasks.forEach(task => {
                        const taskElement = document.createElement('div');
                        taskElement.className = 'bg-gray-600/50 backdrop-blur-sm border border-gray-500/30 rounded-lg sm:rounded-xl p-3 sm:p-4 hover:bg-gray-600/70 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1';
                        taskElement.innerHTML = `
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 sm:space-x-3 mb-2">
                                        <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full ${task.status === 'completed' ? 'bg-green-400' : 'bg-yellow-400'} shadow-sm"></div>
                                        <h4 class="font-semibold text-white text-sm sm:text-base lg:text-lg">${task.title}</h4>
                                    </div>
                                    <p class="text-xs sm:text-sm text-gray-300 mb-2 sm:mb-3">${task.goal_title || 'No Goal'}</p>
                                    <div class="flex items-center space-x-2 sm:space-x-3">
                                        <span class="px-2 sm:px-3 py-1 text-xs font-medium rounded-full ${task.status === 'completed' ? 'bg-green-500/20 text-green-300 border border-green-500/30' : 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30'}">
                                            ${task.status.charAt(0).toUpperCase() + task.status.slice(1)}
                                        </span>
                                        <span class="px-2 sm:px-3 py-1 text-xs font-medium rounded-full ${task.priority === 'high' ? 'bg-red-500/20 text-red-300 border border-red-500/30' : (task.priority === 'medium' ? 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30' : 'bg-green-500/20 text-green-300 border border-green-500/30')}">
                                            ${task.priority.charAt(0).toUpperCase() + task.priority.slice(1)}
                                        </span>
                                    </div>
                                </div>
                                <a href="/tasks/${task.id}" class="text-gray-400 hover:text-pink-400 ml-2 sm:ml-4 p-1.5 sm:p-2 hover:bg-gray-500/30 rounded-lg transition-all duration-300 transform hover:scale-110">
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
                    goalsList.innerHTML = '<div class="flex items-center justify-center h-full min-h-[150px] sm:min-h-[200px]"><p class="text-gray-400 text-center text-sm sm:text-base">No goals active on this date</p></div>';
                } else {
                    data.goals.forEach(goal => {
                        const goalElement = document.createElement('div');
                        goalElement.className = 'bg-gray-600/50 backdrop-blur-sm border border-gray-500/30 rounded-lg sm:rounded-xl p-3 sm:p-4 hover:bg-gray-600/70 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1';
                        goalElement.innerHTML = `
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 sm:space-x-3 mb-2">
                                        <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full ${goal.status === 'completed' ? 'bg-green-400' : 'bg-yellow-400'} shadow-sm"></div>
                                        <h4 class="font-semibold text-white text-sm sm:text-base lg:text-lg">${goal.title}</h4>
                                    </div>
                                    <div class="mb-2 sm:mb-3">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-xs sm:text-sm text-gray-300">Progress</span>
                                            <span class="text-xs sm:text-sm font-semibold text-blue-300">${goal.progress_percent}%</span>
                                        </div>
                                        <div class="w-full bg-gray-500/30 rounded-full h-2 overflow-hidden">
                                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-500" style="width: ${goal.progress_percent}%"></div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2 sm:space-x-3">
                                        <span class="px-2 sm:px-3 py-1 text-xs font-medium rounded-full ${goal.status === 'completed' ? 'bg-green-500/20 text-green-300 border border-green-500/30' : 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30'}">
                                            ${goal.status.charAt(0).toUpperCase() + goal.status.slice(1)}
                                        </span>
                                        <span class="px-2 sm:px-3 py-1 text-xs font-medium rounded-full ${goal.priority === 'high' ? 'bg-red-500/20 text-red-300 border border-red-500/30' : (goal.priority === 'medium' ? 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30' : 'bg-green-500/20 text-green-300 border border-green-500/30')}">
                                            ${goal.priority.charAt(0).toUpperCase() + goal.priority.slice(1)}
                                        </span>
                                    </div>
                                </div>
                                <a href="/goals/${goal.id}" class="text-gray-400 hover:text-blue-400 ml-2 sm:ml-4 p-1.5 sm:p-2 hover:bg-gray-500/30 rounded-lg transition-all duration-300 transform hover:scale-110">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        `;
                        goalsList.appendChild(goalElement);
                    });
                }
            }
            
            // Show modal with animation
            modal.style.display = 'flex';
            modal.classList.remove('hidden');
            
            // Animate modal content
            setTimeout(() => {
                const modalContent = document.getElementById('modalContent');
                if (modalContent) {
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                }
                
                // Set max height for scrollable content
                const tasksList = document.getElementById('tasksList');
                const goalsList = document.getElementById('goalsList');
                
                if (tasksList) {
                    tasksList.style.maxHeight = window.innerWidth < 640 ? '300px' : '400px';
                }
                if (goalsList) {
                    goalsList.style.maxHeight = window.innerWidth < 640 ? '300px' : '400px';
                }
            }, 10);
        })
        .catch(error => {
            console.error('Error fetching date details:', error);
            alert('Error loading date details. Please try again.');
        });
}

function closeDateModal() {
    const modal = document.getElementById('dateModal');
    const modalContent = document.getElementById('modalContent');
    
    if (modal && modalContent) {
        // Animate modal closing
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        // Hide modal after animation
        setTimeout(() => {
            modal.style.display = 'none';
            modal.classList.add('hidden');
            
            // Re-enable body scroll when modal is closed
            document.body.classList.remove('modal-open');
        }, 300);
    }
}

// Filter Functions
document.addEventListener('DOMContentLoaded', function() {
    const priorityFilter = document.getElementById('priorityFilter');
    const statusFilter = document.getElementById('statusFilter');
    const categoryFilter = document.getElementById('categoryFilter');
    
    function applyFilters() {
        const priority = priorityFilter.value;
        const status = statusFilter.value;
        const category = categoryFilter.value;
        
        // Get all calendar days
        const calendarDays = document.querySelectorAll('.grid.grid-cols-7 > div');
        
        calendarDays.forEach(day => {
            const taskElements = day.querySelectorAll('[data-priority]');
            let hasVisibleTasks = false;
            let visibleCount = 0;
            
            taskElements.forEach((taskElement, index) => {
                const taskPriority = taskElement.getAttribute('data-priority');
                const taskStatus = taskElement.getAttribute('data-status');
                const taskCategory = taskElement.getAttribute('data-category');
                
                let shouldShow = true;
                
                // Apply priority filter
                if (priority && taskPriority !== priority) {
                    shouldShow = false;
                }
                
                // Apply status filter
                if (status && taskStatus !== status) {
                    shouldShow = false;
                }
                
                // Apply category filter
                if (category && taskCategory !== category) {
                    shouldShow = false;
                }
                
                if (shouldShow) {
                    taskElement.style.display = 'flex';
                    hasVisibleTasks = true;
                    visibleCount++;
                    
                    // Show only first 3 tasks when filtering
                    if (visibleCount > 3) {
                        taskElement.style.display = 'none';
                    }
                } else {
                    taskElement.style.display = 'none';
                }
            });
            
            // Update "more" indicator
            const moreIndicator = day.querySelector('.text-xs.text-gray-400.text-center');
            if (moreIndicator && visibleCount > 3) {
                moreIndicator.textContent = `${visibleCount - 3} more...`;
                moreIndicator.style.display = 'block';
            } else if (moreIndicator) {
                moreIndicator.style.display = 'none';
            }
            
            // Show/hide the entire day if no tasks are visible
            if (!hasVisibleTasks && (priority || status || category)) {
                day.style.opacity = '0.3';
                day.style.pointerEvents = 'none';
            } else {
                day.style.opacity = '1';
                day.style.pointerEvents = 'auto';
            }
        });
        
        // Show filter status
        const activeFilters = [priority, status, category].filter(f => f).length;
        if (activeFilters > 0) {
            showFilterStatus(activeFilters);
        } else {
            hideFilterStatus();
        }
    }
    
    function showFilterStatus(count) {
        let statusElement = document.getElementById('filterStatus');
        if (!statusElement) {
            statusElement = document.createElement('div');
            statusElement.id = 'filterStatus';
            statusElement.className = 'fixed top-2 sm:top-4 right-2 sm:right-4 bg-pink-500 text-white px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg shadow-lg z-50 text-sm sm:text-base';
            document.body.appendChild(statusElement);
        }
        statusElement.textContent = `${count} filter(s) active`;
        statusElement.style.display = 'block';
    }
    
    function hideFilterStatus() {
        const statusElement = document.getElementById('filterStatus');
        if (statusElement) {
            statusElement.style.display = 'none';
        }
    }
    
    // Add clear filters button
    function addClearFiltersButton() {
        const filterContainer = document.querySelector('.flex.flex-col.sm\\:flex-row.flex-wrap.items-start.sm\\:items-center.gap-4.sm\\:gap-6');
        const clearButton = document.createElement('button');
        clearButton.id = 'clearFilters';
        clearButton.className = 'bg-gray-600 hover:bg-gray-700 text-white px-2 sm:px-3 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition-colors duration-300 w-full sm:w-auto';
        clearButton.textContent = 'Clear Filters';
        clearButton.onclick = function() {
            priorityFilter.value = '';
            statusFilter.value = '';
            categoryFilter.value = '';
            applyFilters();
        };
        filterContainer.appendChild(clearButton);
    }
    
    [priorityFilter, statusFilter, categoryFilter].forEach(filter => {
        filter.addEventListener('change', applyFilters);
    });
    
    // Initialize clear filters button
    addClearFiltersButton();
    

    
    // View toggle
    const listView = document.getElementById('listView');
    const calendarView = document.getElementById('calendarView');
    
    listView.addEventListener('click', function() {
        this.classList.add('bg-gray-600', 'shadow-sm', 'text-white');
        this.classList.remove('text-gray-400');
        calendarView.classList.remove('bg-gray-600', 'shadow-sm', 'text-white');
        calendarView.classList.add('text-gray-400');
        
        // Switch to list view (you can implement this)
        console.log('Switching to list view');
    });
    
    calendarView.addEventListener('click', function() {
        this.classList.add('bg-gray-600', 'shadow-sm', 'text-white');
        this.classList.remove('text-gray-400');
        listView.classList.remove('bg-gray-600', 'shadow-sm', 'text-white');
        listView.classList.add('text-gray-400');
        
        // Switch to calendar view
        console.log('Switching to calendar view');
    });
});

// Close modal when clicking outside
document.getElementById('dateModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDateModal();
    }
});

// Prevent scroll on modal background
document.getElementById('dateModal').addEventListener('wheel', function(e) {
    // Only prevent scroll if the event target is the modal background
    if (e.target === this) {
        e.preventDefault();
    }
}, { passive: false });

// Prevent scroll on modal background with touch events
document.getElementById('dateModal').addEventListener('touchmove', function(e) {
    // Only prevent scroll if the event target is the modal background
    if (e.target === this) {
        e.preventDefault();
    }
}, { passive: false });
</script>

<style>
.bg-gray-25 {
    background-color: #fafafa;
}

.calendar-day:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
}

@media (min-width: 640px) {
    .calendar-day:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }
}

.event-item {
    transition: all 0.3s ease-in-out;
}

.event-item:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fadeIn {
    animation: fadeIn 0.5s ease-out;
}

/* Dark theme scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #374151;
}

::-webkit-scrollbar-thumb {
    background: #6B7280;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #9CA3AF;
}

/* Ensure calendar days are clickable */
.calendar-day {
    position: relative;
    z-index: 1;
}

/* Style for clickable days */
.clickable-day {
    position: relative;
}

.clickable-day::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: transparent;
    z-index: 1;
    pointer-events: none;
}

.clickable-day:hover::after {
    background: rgba(236, 72, 153, 0.1);
    pointer-events: none;
}

/* Modal styles */
#dateModal {
    display: none;
}

#dateModal:not(.hidden) {
    display: flex !important;
}

/* Prevent body scroll when modal is open */
body.modal-open {
    overflow: hidden;
    position: fixed;
    width: 100%;
}

/* Custom scrollbar for modal content */
.custom-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: #6B7280 #374151;
}

.custom-scrollbar::-webkit-scrollbar {
    width: 8px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(55, 65, 81, 0.3);
    border-radius: 10px;
    margin: 4px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #6B7280 0%, #9CA3AF 100%);
    border-radius: 10px;
    border: 2px solid rgba(55, 65, 81, 0.3);
    transition: all 0.3s ease;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg, #9CA3AF 0%, #D1D5DB 100%);
    transform: scale(1.1);
}

.custom-scrollbar::-webkit-scrollbar-corner {
    background: transparent;
}

/* Ensure modal content scrolls properly */
#dateModal .flex-1 {
    overflow-y: auto;
    overflow-x: hidden;
}

/* Modal grid layout */
#dateModal .grid {
    min-height: 400px;
}

@media (max-width: 640px) {
    #dateModal .grid {
        min-height: 300px;
    }
}

/* Ensure scrollable areas have proper height */
#tasksList, #goalsList {
    min-height: 150px;
    max-height: 400px;
}

@media (max-width: 640px) {
    #tasksList, #goalsList {
        min-height: 120px;
        max-height: 300px;
    }
}

/* Smooth scrolling for custom scrollbar */
.custom-scrollbar {
    scroll-behavior: smooth;
}


</style>
@endsection 