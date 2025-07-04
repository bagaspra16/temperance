@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Stats Cards -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700">Total Goals</h2>
            <p class="text-3xl font-bold">{{ $totalGoals }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700">Completed Goals</h2>
            <p class="text-3xl font-bold">{{ $completedGoals }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700">Total Tasks</h2>
            <p class="text-3xl font-bold">{{ $totalTasks }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700">Completed Tasks</h2>
            <p class="text-3xl font-bold">{{ $completedTasks }}</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Categories Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Your Categories</h2>
                <a href="{{ route('categories.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm">Add New</a>
            </div>
            
            @if($categories->count() > 0)
                <div class="space-y-3">
                    @foreach($categories as $category)
                        <div class="flex items-center p-3 border rounded-md" style="border-left-color: {{ $category->color }}; border-left-width: 4px;">
                            <div class="flex-1">
                                <h3 class="font-medium">{{ $category->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $category->goals->count() }} goals</p>
                            </div>
                            <a href="{{ route('categories.show', $category->id) }}" class="text-blue-500 hover:text-blue-700">View</a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No categories yet. Create your first category to organize your goals.</p>
            @endif
        </div>
        
        <!-- Upcoming Goals Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Upcoming Goals</h2>
                <a href="{{ route('goals.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm">Add New</a>
            </div>
            
            @if($upcomingGoals->count() > 0)
                <div class="space-y-3">
                    @foreach($upcomingGoals as $goal)
                        <div class="p-3 border rounded-md">
                            <div class="flex justify-between">
                                <h3 class="font-medium">{{ $goal->title }}</h3>
                                <span class="text-sm px-2 py-1 rounded {{ $goal->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ ucfirst($goal->formatted_status) }}</span>
                            </div>
                            <div class="mt-2">
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $goal->progress_percent }}%;"></div>
                                </div>
                                <div class="flex justify-between mt-1">
                                    <span class="text-xs text-gray-500">{{ $goal->progress_percent }}% complete</span>
                                    <span class="text-xs text-gray-500">{{ $goal->end_date ? 'Due ' . $goal->end_date->format('M d, Y') : 'No end date' }}</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('goals.show', $goal->id) }}" class="text-sm text-blue-500 hover:text-blue-700">View Details</a>
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
    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Recent Tasks</h2>
            <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm">Add New</a>
        </div>
        
        @if($recentTasks->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Goal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentTasks as $task)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $task->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $task->goal->title ?? 'No Goal' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $task->due_date ? $task->due_date->format('M d, Y') : 'No due date' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $task->status === 'completed' ? 'bg-green-100 text-green-800' : ($task->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $task->priority === 'high' ? 'bg-red-100 text-red-800' : ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('tasks.show', $task->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                    @if($task->status !== 'completed')
                                        <form action="{{ route('tasks.complete', $task->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900">Complete</button>
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
</div>
@endsection