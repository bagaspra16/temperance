@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('goals.index') }}" class="text-blue-500 hover:text-blue-700">&larr; Back to Goals</a>
    </div>
    
    <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
        <div class="h-2" style="background-color: {{ $goal->category->color }};"></div>
        <div class="p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{ $goal->title }}</h1>
                    <p class="text-gray-600 mb-2">{{ $goal->description }}</p>
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span>Category: <a href="{{ route('categories.show', $goal->category->id) }}" class="font-medium" style="color: {{ $goal->category->color }};">{{ $goal->category->name }}</a></span>
                        @if($goal->target_date)
                            <span>Target Date: {{ $goal->target_date->format('M d, Y') }}</span>
                        @endif
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('goals.edit', $goal->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md">Edit</a>
                    <form action="{{ route('goals.destroy', $goal->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this goal?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md">Delete</button>
                    </form>
                </div>
            </div>
            
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-semibold">Progress</h3>
                    <span class="text-sm px-2 py-1 rounded-full 
                        {{ $goal->status === 'complete' ? 'bg-green-100 text-green-800' : 
                        ($goal->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ $goal->formatted_status }}
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $goal->progress_percent }}%;"></div>
                </div>
                <div class="text-right text-sm text-gray-500 mt-1">{{ $goal->progress_percent }}% complete</div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Update Progress</h3>
                <form action="{{ route('goals.progress', $goal->id) }}" method="POST" class="flex items-end space-x-4">
                    @csrf
                    @method('PATCH')
                    <div class="flex-1">
                        <label for="progress_percent" class="block text-gray-700 text-sm mb-1">Progress Percentage</label>
                        <input type="range" name="progress_percent" id="progress_percent" min="0" max="100" step="5" 
                            value="{{ $goal->progress_percent }}" class="w-full" 
                            oninput="updateProgressValue.innerText = this.value + '%'; updateStatus(this.value);">
                        <div class="text-right text-gray-500 text-sm">
                            <span id="updateProgressValue">{{ $goal->progress_percent }}%</span>
                        </div>
                    </div>
                    <div class="w-1/4">
                        <label for="status" class="block text-gray-700 text-sm mb-1">Status</label>
                        <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 text-sm">
                            <option value="not_started" {{ $goal->status == 'not_started' ? 'selected' : '' }}>Not Started</option>
                            <option value="in_progress" {{ $goal->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="complete" {{ ($goal->status == 'complete' || $goal->status == 'completed') ? 'selected' : '' }}>Complete</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm">Update</button>
                    </div>
                </form>
                
                <script>
                    function updateStatus(value) {
                        const statusSelect = document.getElementById('status');
                        if (value == 0) {
                            statusSelect.value = 'not_started';
                        } else if (value == 100) {
                            statusSelect.value = 'complete';
                        } else {
                            statusSelect.value = 'in_progress';
                        }
                    }
                </script>
            </div>
        </div>
    </div>
    
    <!-- Tasks Section -->
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold">Tasks</h2>
        <a href="{{ route('tasks.create', ['goal_id' => $goal->id]) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Add New Task</a>
    </div>
    
    @if($goal->tasks->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
            <ul class="divide-y divide-gray-200">
                @foreach($goal->tasks as $task)
                    <li class="p-4 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <form action="{{ route('tasks.complete', $task->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex-shrink-0 h-5 w-5 rounded-full border-2 {{ $task->status === 'completed' ? 'bg-blue-500 border-blue-500' : 'border-gray-300' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"></button>
                                </form>
                                <div>
                                    <h3 class="text-lg font-medium {{ $task->status === 'completed' ? 'line-through text-gray-500' : 'text-gray-900' }}">{{ $task->title }}</h3>
                                    @if($task->description)
                                        <p class="text-sm text-gray-500">{{ Str::limit($task->description, 100) }}</p>
                                    @endif
                                    @if($task->due_date)
                                        <p class="text-xs text-gray-500 mt-1">Due: {{ $task->due_date->format('M d, Y') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('tasks.show', $task->id) }}" class="text-blue-500 hover:text-blue-700">View</a>
                                <a href="{{ route('tasks.edit', $task->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-6 text-center mb-8">
            <p class="text-gray-500 mb-4">No tasks for this goal yet.</p>
            <a href="{{ route('tasks.create', ['goal_id' => $goal->id]) }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Create Your First Task</a>
        </div>
    @endif
    
    <!-- Progress History Section -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold">Progress History</h2>
    </div>
    
    @if($goal->progressRecords->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <ul class="divide-y divide-gray-200">
                @foreach($goal->progressRecords->sortByDesc('created_at') as $record)
                    <li class="p-4 hover:bg-gray-50">
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium">Progress updated to {{ $record->percentage }}%</span>
                                    <span class="text-xs px-2 py-1 rounded-full {{ $record->status === 'Completed' ? 'bg-green-100 text-green-800' : ($record->status === 'In Progress' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ $record->status }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500">{{ $record->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <div>
                                <a href="{{ route('progress.show', $record->id) }}" class="text-blue-500 hover:text-blue-700 text-sm">Details</a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-500">No progress history available.</p>
        </div>
    @endif
</div>
@endsection