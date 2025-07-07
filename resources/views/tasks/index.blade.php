@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-800">All Tasks</h1>
        <a href="{{ route('tasks.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
            <i class="fas fa-plus mr-2"></i> Add New Task
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        @if($tasks->count() > 0)
            @include('tasks._list', ['tasks' => $tasks])
        @else
            <div class="text-center p-12">
                <img src="{{ asset('img/no-tasks.svg') }}" alt="No Tasks" class="mx-auto h-40 mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">All Tasks Clear!</h2>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">You have no pending tasks. Create a new task to get started or enjoy the peace of mind!</p>
                <a href="{{ route('tasks.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300 inline-block">
                    <i class="fas fa-plus mr-2"></i> Create a New Task
                </a>
            </div>
        @endif
    </div>
</div>
@endsection