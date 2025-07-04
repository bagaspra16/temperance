@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Goals</h1>
        <a href="{{ route('goals.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Add New Goal</a>
    </div>
    
    @if($goals->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($goals as $goal)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="h-2" style="background-color: {{ $goal->category->color }};"></div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h2 class="text-xl font-semibold">{{ $goal->title }}</h2>
                            <span class="text-sm px-2 py-1 rounded-full {{ $goal->status === 'Completed' ? 'bg-green-100 text-green-800' : ($goal->status === 'In Progress' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ $goal->formatted_status }}
                            </span>
                        </div>
                        
                        <p class="text-gray-600 mb-4">{{ Str::limit($goal->description, 100) }}</p>
                        
                        <div class="mb-4">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $goal->progress_percent }}%;"></div>
                            </div>
                            <div class="flex justify-between text-sm text-gray-500 mt-1">
                                <span>Progress: {{ $goal->progress_percent }}%</span>
                                <span>{{ $goal->tasks->count() }} tasks</span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Category: <span class="font-medium" style="color: {{ $goal->category->color }};">{{ $goal->category->name }}</span></span>
                            <div class="flex space-x-2">
                                <a href="{{ route('goals.show', $goal->id) }}" class="text-blue-500 hover:text-blue-700">View</a>
                                <a href="{{ route('goals.edit', $goal->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a>
                                <form action="{{ route('goals.destroy', $goal->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this goal?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-500 mb-4">You don't have any goals yet.</p>
            <a href="{{ route('goals.create') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Create Your First Goal</a>
        </div>
    @endif
</div>
@endsection