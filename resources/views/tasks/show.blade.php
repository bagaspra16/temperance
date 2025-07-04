@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('tasks.index') }}" class="text-blue-500 hover:text-blue-700">&larr; Back to Tasks</a>
    </div>
    
    <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
        <div class="p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <div class="flex items-center space-x-3 mb-2">
                        <form action="{{ route('tasks.complete', $task->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="flex-shrink-0 h-6 w-6 rounded-full border-2 {{ $task->status === 'completed' ? 'bg-blue-500 border-blue-500' : 'border-gray-300' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"></button>
                        </form>
                        <h1 class="text-3xl font-bold {{ $task->status === 'completed' ? 'line-through text-gray-500' : 'text-gray-900' }}">{{ $task->title }}</h1>
                    </div>
                    <p class="text-gray-600 mb-4">{{ $task->description }}</p>
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span>Goal: <a href="{{ route('goals.show', $task->goal->id) }}" class="font-medium text-blue-500">{{ $task->goal->title }}</a></span>
                        <span>Category: <a href="{{ route('categories.show', $task->goal->category->id) }}" class="font-medium" style="color: {{ $task->goal->category->color }};">{{ $task->goal->category->name }}</a></span>
                        @if($task->due_date)
                            <span class="{{ $task->due_date->isPast() && !$task->completed ? 'text-red-500 font-medium' : '' }}">Due: {{ $task->due_date->format('M d, Y') }}</span>
                        @endif
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('tasks.edit', $task->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md">Edit</a>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this task?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md">Delete</button>
                    </form>
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-4 mt-4">
                <h3 class="text-lg font-semibold mb-2">Task Status</h3>
                <div class="flex items-center space-x-2">
                    <span class="text-sm px-2 py-1 rounded-full {{ $task->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $task->status === 'completed' ? 'Completed' : 'Pending' }}
                    </span>
                    @if($task->completed_at)
                        <span class="text-sm text-gray-500">Completed on {{ $task->completed_at->format('M d, Y H:i') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Goal Progress Impact -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-4">Goal Progress</h2>
        <div class="bg-white rounded-lg shadow overflow-hidden p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold">{{ $task->goal->title }}</h3>
                    <p class="text-sm text-gray-500">{{ $task->goal->status }}</p>
                </div>
                <a href="{{ route('goals.show', $task->goal->id) }}" class="text-blue-500 hover:text-blue-700">View Goal</a>
            </div>
            
            <div class="mb-2">
                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $task->goal->progress_percent }}%;"></div>
                </div>
                <div class="flex justify-between text-sm text-gray-500 mt-1">
                    <span>Progress: {{ $task->goal->progress_percent }}%</span>
                    <span>{{ $task->goal->tasks->count() }} tasks total</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Progress History -->
    @if($task->progressRecords && $task->progressRecords->count() > 0)
        <div class="mb-6">
            <h2 class="text-2xl font-bold mb-4">Progress History</h2>
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <ul class="divide-y divide-gray-200">
                    @foreach($task->progressRecords->sortByDesc('created_at') as $record)
                        <li class="p-4 hover:bg-gray-50">
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-medium">{{ $record->note }}</span>
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
        </div>
    @endif
</div>
@endsection