@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="{
    progress: {{ $goal->progress_percent }},
    status: '{{ $goal->status }}',
    updateStatus(value) {
        if (value == 100) {
            this.status = 'completed';
        } else if (value > 0) {
            this.status = 'in_progress';
        } else {
            this.status = 'not_started';
        }
    }
}">
    <div class="mb-6">
        <a href="{{ route('goals.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors duration-300">
            <i class="fas fa-arrow-left mr-2"></i> Back to All Goals
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
        <div class="h-3" style="background-color: {{ $goal->category->color ?? '#ccc' }};"></div>
        <div class="p-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start mb-6">
                <div class="mb-4 md:mb-0">
                    <span class="text-sm font-semibold px-3 py-1 rounded-full mb-3 inline-block" style="background-color: {{ $goal->category->color }}20; color: {{ $goal->category->color }};">{{ $goal->category->name }}</span>
                    <h1 class="text-4xl font-bold text-gray-800">{{ $goal->title }}</h1>
                    <p class="text-gray-600 mt-2 max-w-2xl">{{ $goal->description }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('goals.edit', $goal->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-2 px-5 rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300">Edit</a>
                    <form action="{{ route('goals.destroy', $goal->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this goal?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-5 rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300">Delete</button>
                    </form>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8 text-center">
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="text-lg font-bold text-gray-800" :class="{
                        'text-green-600': status === 'completed',
                        'text-blue-600': status === 'in_progress',
                        'text-gray-600': status === 'not_started'
                    }" x-text="status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())">{{ $goal->formatted_status }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-sm text-gray-500">Target Date</p>
                    <p class="text-lg font-bold text-gray-800">{{ $goal->end_date ? $goal->end_date->format('M d, Y') : 'Not Set' }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-sm text-gray-500">Tasks</p>
                    <p class="text-lg font-bold text-gray-800">{{ $goal->tasks->where('is_completed', true)->count() }} / {{ $goal->tasks->count() }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-sm text-gray-500">Days Left</p>
                    <p class="text-lg font-bold text-gray-800">{{ $goal->days_duration }}</p>
                </div>
            </div>

            <!-- Progress Update -->
            <div class="bg-blue-50 border-2 border-blue-100 rounded-xl p-6 mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Update Progress</h3>
                <form action="{{ route('goals.progress', $goal->id) }}" method="POST" class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6">
                    @csrf
                    @method('PATCH')
                    <div class="flex-grow w-full">
                        <label for="progress_percent" class="block text-gray-700 text-sm font-medium mb-2">Progress: <span x-text="progress + '%'" class="font-bold"></span></label>
                        <input type="range" name="progress_percent" id="progress_percent" min="0" max="100" step="5" 
                               x-model="progress" @input="updateStatus($event.target.value)"
                               class="w-full h-3 bg-gray-200 rounded-lg appearance-none cursor-pointer range-lg">
                    </div>
                    <div class="w-full sm:w-1/4">
                        <label for="status" class="block text-gray-700 text-sm font-medium mb-2">Status</label>
                        <select name="status" id="status" x-model="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="not_started">Not Started</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div class="w-full sm:w-auto">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Tasks and Progress History Tabs -->
    <div x-data="{ tab: 'tasks' }">
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button @click="tab = 'tasks'" :class="{ 'border-blue-500 text-blue-600': tab === 'tasks', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'tasks' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg">
                    Tasks ({{ $goal->tasks->count() }})
                </button>
                <button @click="tab = 'history'" :class="{ 'border-blue-500 text-blue-600': tab === 'history', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'history' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg">
                    Progress History
                </button>
            </nav>
        </div>

        <!-- Tasks Section -->
        <div x-show="tab === 'tasks'">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-gray-800">Tasks</h2>
                <a href="{{ route('tasks.create', ['goal_id' => $goal->id]) }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-5 rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300">
                    <i class="fas fa-plus mr-2"></i> Add Task
                </a>
            </div>
            @if($goal->tasks->count() > 0)
                @include('tasks._list', ['tasks' => $goal->tasks])
            @else
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <i class="fas fa-check-square text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700">No Tasks Yet</h3>
                    <p class="text-gray-500 mt-2">Add tasks to this goal to start making progress.</p>
                </div>
            @endif
        </div>

        <!-- Progress History Section -->
        <div x-show="tab === 'history'" style="display: none;">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Progress History</h2>
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                @if($progressHistory->count() > 0)
                    <ul class="divide-y divide-gray-200">
                        @foreach($progressHistory as $record)
                            <li class="p-6 hover:bg-gray-50 transition-colors duration-200">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-lg font-semibold text-gray-800">
                                            @if($record->progressable_type === 'App\Models\Task')
                                                Task "<span class="font-bold text-gray-900">{{ $record->progressable->title }}</span>" completed.
                                            @else
                                                Goal progress updated to <span class="font-bold text-blue-600">{{ $record->progress_value }}%</span>.
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-500 mt-1">{{ $record->created_at->format('M d, Y \a\t h:i A') }}</p>
                                        @if($record->note)
                                            <p class="text-gray-600 mt-2 pl-4 border-l-2 border-gray-200">{{ $record->note }}</p>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <span class="text-sm font-semibold px-3 py-1 rounded-full
                                            @if($record->progressable_type === 'App\Models\Task') bg-green-100 text-green-800
                                            @else bg-blue-100 text-blue-800 @endif">
                                            @if($record->progressable_type === 'App\Models\Task') Task Completed
                                            @else Manual Update @endif
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="p-12 text-center">
                        <i class="fas fa-history text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-700">No History Yet</h3>
                        <p class="text-gray-500 mt-2">Progress updates for this goal will appear here.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush