@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('categories.index') }}" class="text-blue-500 hover:text-blue-700">&larr; Back to Categories</a>
    </div>
    
    <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
        <div class="h-2" style="background-color: {{ $category->color }};"></div>
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{ $category->name }}</h1>
                    <p class="text-gray-600 mb-4">{{ $category->description }}</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('categories.edit', $category->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md">Edit</a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold">Goals in this Category</h2>
        <a href="{{ route('goals.create', ['category_id' => $category->id]) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Add New Goal</a>
    </div>
    
    @if($category->goals->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($category->goals as $goal)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">{{ $goal->title }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($goal->description, 100) }}</p>
                        
                        <div class="mb-4">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $goal->progress_percentage }}%;"></div>
                            </div>
                            <div class="flex justify-between text-sm text-gray-500 mt-1">
                                <span>Progress: {{ $goal->progress_percentage }}%</span>
                                <span>{{ $goal->status }}</span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">{{ $goal->tasks->count() }} tasks</span>
                            <div class="flex space-x-2">
                                <a href="{{ route('goals.show', $goal->id) }}" class="text-blue-500 hover:text-blue-700">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-500 mb-4">No goals in this category yet.</p>
            <a href="{{ route('goals.create', ['category_id' => $category->id]) }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Create Your First Goal</a>
        </div>
    @endif
</div>
@endsection