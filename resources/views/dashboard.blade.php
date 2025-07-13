@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 text-pink-500">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Dashboard</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Stats Cards -->
        <div class="bg-gray-800 rounded-lg shadow p-6 flex items-center justify-between transform hover:scale-105 transition-transform duration-300">
            <div>
                <h2 class="text-lg font-semibold">Total Goals</h2>
                <p class="text-3xl font-bold">{{ $totalGoals }}</p>
            </div>
            <i class="fas fa-bullseye text-4xl text-pink-500"></i>
        </div>

        <div class="bg-gray-800 rounded-lg shadow p-6 flex items-center justify-between transform hover:scale-105 transition-transform duration-300">
            <div>
                <h2 class="text-lg font-semibold">Completed Goals</h2>
                <p class="text-3xl font-bold">{{ $completedGoals }}</p>
            </div>
            <i class="fas fa-check-circle text-4xl text-green-500"></i>
        </div>

        <div class="bg-gray-800 rounded-lg shadow p-6 flex items-center justify-between transform hover:scale-105 transition-transform duration-300">
            <div>
                <h2 class="text-lg font-semibold">Total Tasks</h2>
                <p class="text-3xl font-bold">{{ $totalTasks }}</p>
            </div>
            <i class="fas fa-tasks text-4xl text-blue-500"></i>
        </div>

        <div class="bg-gray-800 rounded-lg shadow p-6 flex items-center justify-between transform hover:scale-105 transition-transform duration-300">
            <div>
                <h2 class="text-lg font-semibold">Completed Tasks</h2>
                <p class="text-3xl font-bold">{{ $completedTasks }}</p>
            </div>
            <i class="fas fa-clipboard-check text-4xl text-purple-500"></i>
        </div>
    </div>

    <!-- Calendar Section -->
    <div class="mt-8 mb-8 bg-gray-800/50 backdrop-blur-sm rounded-2xl sm:rounded-3xl shadow-2xl overflow-hidden border border-gray-600/50">
        <!-- Calendar Header -->
        <div class="bg-gradient-to-r from-gray-700/90 to-gray-800/90 backdrop-blur-sm p-4 sm:p-6 border-b border-gray-600/50">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                <div class="flex items-center space-x-3 sm:space-x-5">
                    <div class="p-2 sm:p-3 lg:p-4 bg-gradient-to-r from-pink-500 to-pink-600 rounded-xl sm:rounded-2xl shadow-lg">
                        <i class="fas fa-calendar-alt text-white text-xl sm:text-2xl lg:text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent">Monthly Calendar</h2>
                        <p class="text-gray-300 text-sm sm:text-base lg:text-lg">View your tasks and goals for {{ $currentDate->format('F Y') }}</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-4 mt-4 sm:mt-0">
                    <a href="{{ route('goals.calendar', ['year' => $currentDate->year, 'month' => $currentDate->month]) }}" class="bg-pink-600 hover:bg-pink-700 text-white font-semibold py-2 px-5 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300 text-center flex items-center">
                        <i class="fas fa-external-link-alt mr-2"></i> Lihat di Menu Calendar
                    </a>
                </div>
            </div>
        </div>

        <!-- Calendar Grid -->
        <div class="bg-gray-800/50 backdrop-blur-sm">
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
                    
                    <div class="calendar-day min-h-[80px] sm:min-h-[100px] md:min-h-[120px] lg:min-h-[140px] border-r border-b border-gray-600/50 p-2 sm:p-3 {{ $day['isCurrentMonth'] ? 'bg-gray-800/50' : 'bg-gray-900/50' }} {{ $day['isToday'] ? 'bg-gradient-to-br from-pink-900/80 to-pink-800/80 border-pink-500/50' : '' }} {{ $day['isWeekend'] ? 'bg-gray-900/50' : '' }} hover:bg-gray-700/70 transition-all duration-300 group {{ ($taskEvents->count() > 0 || $goalEvents->count() > 0) ? 'cursor-pointer' : '' }}"
                         @if($taskEvents->count() > 0 || $goalEvents->count() > 0)
                         onclick="showDateDetails('{{ $day['date']->format('Y-m-d') }}', '{{ $day['date']->format('l, F j, Y') }}')"
                         @endif>
                        
                        <!-- Date Number -->
                        <div class="flex justify-between items-start mb-1 sm:mb-2">
                            <span class="text-xs sm:text-sm font-bold {{ $day['isCurrentMonth'] ? 'text-white' : 'text-gray-500' }} {{ $day['isToday'] ? 'bg-gradient-to-r from-pink-500 to-pink-600 text-white rounded-full w-5 h-5 sm:w-6 sm:h-6 lg:w-8 lg:h-8 flex items-center justify-center shadow-lg' : '' }} group-hover:scale-110 transition-transform duration-200">
                                {{ $day['date']->format('j') }}
                            </span>
                            @if($day['isToday'])
                                <span class="text-xs text-pink-300 font-bold bg-pink-900/50 px-1 sm:px-1.5 py-0.5 rounded-full border border-pink-500/30">TODAY</span>
                            @endif
                        </div>

                        <!-- Task Events Only -->
                        <div class="space-y-1">
                            @foreach($taskEvents->take(1) as $event)
                                <div class="group/event relative">
                                    <div class="flex items-center p-1 sm:p-1.5 rounded-lg text-xs hover:bg-gray-600/50 hover:shadow-md transition-all duration-200 transform hover:scale-105 backdrop-blur-sm"
                                         style="border-left: 2px solid {{ $event['color'] }}; background: linear-gradient(90deg, {{ $event['color'] }}15 0%, transparent 100%);"
                                         data-priority="{{ $event['priority'] }}" 
                                         data-status="{{ $event['status'] }}" 
                                         data-category="{{ $event['task']->goal->category->id ?? '' }}">
                                        <div class="w-1 h-1 sm:w-1.5 sm:h-1.5 rounded-full mr-1 shadow-sm" style="background-color: {{ $event['color'] }};"></div>
                                        <span class="font-semibold text-gray-200 truncate text-xs">{{ $event['title'] }}</span>
                                        @if($event['priority'] === 'high')
                                            <i class="fas fa-exclamation-triangle text-red-400 ml-1 text-xs animate-pulse"></i>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            <!-- More Tasks Indicator -->
                            @if($taskEvents->count() > 1)
                                <div class="text-xs text-gray-400 text-center py-0.5 sm:py-1 bg-gray-700/50 rounded-lg font-medium backdrop-blur-sm border border-gray-600/30">
                                    {{ $taskEvents->count() - 1 }} more...
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Categories Section -->
        <div class="bg-gray-800 rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Your Categories</h2>
                <a href="{{ route('categories.create') }}" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-md text-sm">Add New</a>
            </div>

            @if($categories->count() > 0)
                <div class="space-y-3">
                    @foreach($categories as $category)
                        <div class="flex items-center p-3 border rounded-md border-gray-600 hover:bg-gray-700 transition-colors duration-200" style="border-left-color: {{ $category->color }}; border-left-width: 4px;">
                            <div class="flex-1">
                                <h3 class="font-medium">{{ $category->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $category->goals->count() }} goals</p>
                            </div>
                            <a href="{{ route('categories.show', $category->id) }}" class="text-pink-500 hover:text-pink-400">View</a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No categories yet. Create your first category to organize your goals.</p>
            @endif
        </div>

        <!-- Upcoming Goals Section -->
        <div class="bg-gray-800 rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Upcoming Goals</h2>
                <a href="{{ route('goals.create') }}" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-md text-sm">Add New</a>
            </div>

            @if($upcomingGoals->count() > 0)
                <div class="space-y-3">
                    @foreach($upcomingGoals as $goal)
                        <div class="p-3 border rounded-md border-gray-600 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex justify-between">
                                <h3 class="font-medium">{{ $goal->title }}</h3>
                                <span class="text-sm px-2 py-1 rounded {{ $goal->status === 'completed' ? 'bg-green-500 text-white' : 'bg-yellow-500 text-white' }}">{{ ucfirst($goal->formatted_status) }}</span>
                            </div>
                            <div class="mt-2">
                                <div class="w-full bg-gray-700 rounded-full h-2.5">
                                    <div class="bg-pink-500 h-2.5 rounded-full" style="width: {{ $goal->progress_percent }}%;"></div>
                                </div>
                                <div class="flex justify-between mt-1">
                                    <span class="text-xs text-gray-400">{{ $goal->progress_percent }}% complete</span>
                                    <span class="text-xs text-gray-400">{{ $goal->end_date ? 'Due ' . $goal->end_date->format('M d, Y') : 'No end date' }}</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('goals.show', $goal->id) }}" class="text-sm text-pink-500 hover:text-pink-400">View Details</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No upcoming goals. Create your first goal to start tracking your progress.</p>
            @endif
        </div>
    </div>

    <!-- Recent Tasks Section -->
    <div class="mt-8 bg-gray-800 rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Recent Tasks</h2>
            <a href="{{ route('tasks.create') }}" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-md text-sm">Add New</a>
        </div>

        @if($recentTasks->count() > 0)
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-900">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Task</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Goal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Due Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Priority</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800 divide-y divide-gray-700">
                        @foreach($recentTasks as $task)
                            <tr class="hover:bg-gray-700 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-white">{{ $task->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-400">{{ $task->goal->title ?? 'No Goal' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-400">{{ $task->due_date ? $task->due_date->format('M d, Y') : 'No due date' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $task->status === 'completed' ? 'bg-green-500 text-white' : ($task->status === 'in_progress' ? 'bg-blue-500 text-white' : 'bg-yellow-500 text-white') }}">
                                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $task->priority === 'high' ? 'bg-red-500 text-white' : ($task->priority === 'medium' ? 'bg-yellow-500 text-white' : 'bg-green-500 text-white') }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('tasks.show', $task->id) }}" class="text-pink-500 hover:text-pink-400 mr-3">View</a>
                                    @if($task->status !== 'completed')
                                        <form action="{{ route('tasks.complete', $task->id) }}" method="POST" class="inline" id="complete-task-form-{{ $task->id }}">
                                            @csrf
                                            <button type="button" onclick="showCompleteConfirmation('{{ $task->id }}', '{{ addslashes($task->title) }}')" class="text-green-500 hover:text-green-400">Complete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">No tasks yet. Create your first task to start tracking your progress.</p>
        @endif
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
</div>
@endsection
@push('scripts')
<script>
// Calendar Functions
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
    fetch(`/dashboard/calendar/details?date=${dateKey}`)
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

// Task Functions
function showCompleteConfirmation(taskId, taskTitle) {
    Swal.fire({
        title: 'Are you sure?',
        html: `This will mark the task "<strong>${taskTitle}</strong>" as complete.`,
        iconHtml: '<div class="w-24 h-24 rounded-full border-4 border-pink-500 flex items-center justify-center mx-auto animate-bounce"><i class="fas fa-check-double text-5xl text-pink-500"></i></div>',
        showCancelButton: true,
        confirmButtonText: 'Yes, Complete It!',
        cancelButtonText: 'Cancel',
        background: 'linear-gradient(to top right, #1f2937, #374151)',
        reverseButtons: true,
        customClass: {
            popup: 'rounded-2xl shadow-2xl border border-gray-700',
            icon: 'no-border',
            title: 'text-3xl font-bold text-pink-400 pt-8',
            htmlContainer: 'text-lg text-gray-300 pb-4',
            actions: 'w-full flex justify-center gap-x-4 px-4',
            confirmButton: 'bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300',
            cancelButton: 'bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300'
        },
        buttonsStyling: false,
        showClass: {
            popup: 'animate__animated animate__fadeIn animate__faster'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOut animate__faster'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('complete-task-form-' + taskId).submit();
        }
    });
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
    #tasksList, #goalsList {
        min-height: 150px;
        max-height: 400px;
    }
    @media (max-width: 640px) {
        #tasksList, #goalsList {
            min-height: 120px;
            max-height: 300px;
        }
        #dateModal .grid {
            min-height: 300px;
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
    }
});
</script>