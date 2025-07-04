@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Categories</h1>
        <a href="{{ route('categories.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Add New Category</a>
    </div>
    
    @if($categories->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="h-2" style="background-color: {{ $category->color }};"></div>
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2">{{ $category->name }}</h2>
                        <p class="text-gray-600 mb-4">{{ $category->description }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">{{ $category->goals->count() }} goals</span>
                            <div class="flex space-x-2">
                                <a href="{{ route('categories.show', $category->id) }}" class="text-blue-500 hover:text-blue-700">View</a>
                                <a href="{{ route('categories.edit', $category->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
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
            <p class="text-gray-500 mb-4">You don't have any categories yet.</p>
            <a href="{{ route('categories.create') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Create Your First Category</a>
        </div>
    @endif
</div>
@endsection