@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('progress.index') }}" class="text-blue-500 hover:text-blue-700">&larr; Back to Progress History</a>
    </div>
    
    <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
        <div class="p-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Progress Record</h1>
                    <p class="text-gray-500">Created on {{ $progress->created_at->format('M d, Y H:i') }}</p>
                </div>
                <form action="{{ route('progress.destroy', $progress->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this progress record?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md">Delete</button>
                </form>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Progress Details -->
                <div class="border rounded-lg p-4">
                    <h2 class="text-lg font-semibold mb-4">Progress Details</h2>
                    
                    @if($progress->percentage !== null)
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Progress Percentage</h3>
                            <div class="w-full bg-gray-200 rounded-full h-4">
                                <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $progress->percentage }}%;"></div>
                            </div>
                            <div class="text-right text-sm text-gray-500 mt-1">{{ $progress->percentage }}%</div>
                        </div>
                    @endif
                    
                    @if($progress->goal)
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Goal Status</h3>
                            <span class="px-2 py-1 text-sm rounded-full {{ $progress->goal->status === 'completed' ? 'bg-green-100 text-green-800' : ($progress->goal->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ $progress->goal->formattedStatus }}
                            </span>
                        </div>
                    @endif
                    
                    @if($progress->task)
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Task Status</h3>
                            <span class="px-2 py-1 text-sm rounded-full {{ $progress->task->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $progress->task->status === 'completed' ? 'Completed' : 'Pending' }}
                            </span>
                        </div>
                    @endif
                    
                    @if($progress->note)
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Notes</h3>
                            <p class="text-gray-700">{{ $progress->note }}</p>
                        </div>
                    @endif
                </div>
                
                <!-- Related Item -->
                <div class="border rounded-lg p-4">
                    @if($progress->goal)
                        <h2 class="text-lg font-semibold mb-4">Related Goal</h2>
                        <div class="mb-2">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Goal</h3>
                            <a href="{{ route('goals.show', $progress->goal->id) }}" class="text-blue-500 hover:text-blue-700 font-medium">{{ $progress->goal->title }}</a>
                        </div>
                        
                        <div class="mb-2">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Category</h3>
                            <a href="{{ route('categories.show', $progress->goal->category->id) }}" class="font-medium" style="color: {{ $progress->goal->category->color }};">{{ $progress->goal->category->name }}</a>
                        </div>
                        
                        <div class="mb-2">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Current Progress</h3>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $progress->goal->progress_percent }}%;"></div>
                            </div>
                            <div class="text-right text-sm text-gray-500 mt-1">{{ $progress->goal->progress_percent }}%</div>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('goals.show', $progress->goal->id) }}" class="text-blue-500 hover:text-blue-700">View Goal Details</a>
                        </div>
                    @elseif($progress->task)
                        <h2 class="text-lg font-semibold mb-4">Related Task</h2>
                        <div class="mb-2">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Task</h3>
                            <a href="{{ route('tasks.show', $progress->task->id) }}" class="text-blue-500 hover:text-blue-700 font-medium">{{ $progress->task->title }}</a>
                        </div>
                        
                        <div class="mb-2">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Goal</h3>
                            <a href="{{ route('goals.show', $progress->task->goal->id) }}" class="text-blue-500 hover:text-blue-700">{{ $progress->task->goal->title }}</a>
                        </div>
                        
                        <div class="mb-2">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Category</h3>
                            <a href="{{ route('categories.show', $progress->task->goal->category->id) }}" class="font-medium" style="color: {{ $progress->task->goal->category->color }};">{{ $progress->task->goal->category->name }}</a>
                        </div>
                        
                        <div class="mb-2">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Current Status</h3>
                            <span class="px-2 py-1 text-sm rounded-full {{ $progress->task->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $progress->task->status === 'completed' ? 'Completed' : 'Pending' }}
                            </span>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('tasks.show', $progress->task->id) }}" class="text-blue-500 hover:text-blue-700">View Task Details</a>
                        </div>
                    @else
                        <p class="text-gray-500">No related goal or task found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection