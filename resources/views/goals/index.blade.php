@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-800">Your Goals</h1>
        <a href="{{ route('goals.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
            <i class="fas fa-plus mr-2"></i> Add New Goal
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if($goals->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($goals as $goal)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 ease-in-out">
                    <div class="h-3" style="background-color: {{ $goal->category->color ?? '#ccc' }};"></div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="text-sm font-semibold px-3 py-1 rounded-full" style="background-color: {{ $goal->category->color }}20; color: {{ $goal->category->color }};">{{ $goal->category->name }}</span>
                            </div>
                            <span class="text-xs font-semibold px-3 py-1 rounded-full 
                                @if($goal->status == 'completed') bg-green-100 text-green-800
                                @elseif($goal->status == 'in_progress') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $goal->formatted_status }}
                            </span>
                        </div>
                        
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $goal->title }}</h2>
                        
                        <p class="text-gray-600 mb-5 h-12">{{ Str::limit($goal->description, 100) }}</p>
                        
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">Progress</span>
                                <span class="text-sm font-bold text-blue-600">{{ $goal->progress_percent }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $goal->progress_percent }}%;"></div>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center text-sm text-gray-500 mb-6">
                            <span><i class="far fa-calendar-alt mr-1"></i> {{ $goal->end_date ? $goal->end_date->format('M d, Y') : 'No Target' }}</span>
                            <span><i class="fas fa-tasks mr-1"></i> {{ $goal->tasks_count }} tasks</span>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-4 flex justify-end items-center space-x-3">
                            <a href="{{ route('goals.show', $goal->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors duration-300">View Details</a>
                            <a href="{{ route('goals.edit', $goal->id) }}" class="text-yellow-500 hover:text-yellow-700 font-semibold transition-colors duration-300">Edit</a>
                            <form action="{{ route('goals.destroy', $goal->id) }}" method="POST" class="inline" id="delete-goal-form-{{ $goal->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="showDeleteConfirmation('delete-goal-form-{{ $goal->id }}', '{{ addslashes($goal->title) }}', 'goal and all its tasks')" class="text-red-500 hover:text-red-700 font-semibold transition-colors duration-300">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $goals->links() }}
        </div>
    @else
        <div class="text-center p-12 bg-white rounded-2xl shadow-lg">
            <img src="{{ asset('img/no-goals.svg') }}" alt="No Goals" class="mx-auto h-40 mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Start Your Journey</h2>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">You haven't set any goals yet. Click the button below to create your first one and start tracking your progress.</p>
            <a href="{{ route('goals.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300 inline-block">
                <i class="fas fa-plus mr-2"></i> Create Your First Goal
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<!-- If you use FontAwesome or another icon library, link it here or in your main layout -->
<!-- <script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script> -->
@endpush