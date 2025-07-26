@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow">Your Goals</h1>
        <div class="flex space-x-4">
            <a href="{{ route('goals.calendar') }}" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-bold py-3 px-6 rounded-2xl shadow-xl transform hover:scale-105 transition-transform duration-300 flex items-center gap-2">
                <i class="fas fa-calendar-alt"></i> Calendar View
            </a>
            <a href="{{ route('goals.create') }}" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-bold py-3 px-6 rounded-2xl shadow-xl transform hover:scale-105 transition-transform duration-300 flex items-center gap-2">
                <i class="fas fa-plus"></i> Add New Goal
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-pink-100 border-l-4 border-pink-500 text-pink-800 p-4 mb-6 rounded-xl shadow" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-xl shadow" role="alert">
            <p class="font-bold">Error</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    @if($goals->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($goals as $goal)
                <div class="bg-gray-800 rounded-3xl shadow-xl overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 ease-in-out border border-pink-500/10">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="text-xs font-semibold px-3 py-1 rounded-full" style="background-color: {{ $goal->category->color }}20; color: {{ $goal->category->color }};">{{ $goal->category->name }}</span>
                            </div>
                            <span class="text-xs font-semibold px-3 py-1 rounded-full 
                                @if($goal->status == 'completed') bg-pink-100 text-pink-700
                                @elseif($goal->status == 'in_progress') bg-pink-200 text-pink-800
                                @else bg-gray-700 text-gray-200 @endif">
                                {{ $goal->formatted_status }}
                            </span>
                        </div>
                        <h2 class="text-2xl font-bold text-white mb-2">{{ $goal->title }}</h2>
                        <p class="text-gray-300 mb-5 h-12">{{ Str::limit($goal->description, 100) }}</p>
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-pink-200">Progress</span>
                                <span class="text-sm font-bold text-pink-400">{{ $goal->progress_percent }}%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2.5">
                                <div class="bg-gradient-to-r from-pink-500 to-pink-700 h-2.5 rounded-full" style="width: {{ $goal->progress_percent }}%;"></div>
                            </div>
                        </div>
                        <div class="flex justify-between items-center text-xs text-gray-400 mb-6">
                            <span><i class="far fa-calendar-alt mr-1"></i> {{ $goal->end_date ? $goal->end_date->format('M d, Y') : 'No Target' }}</span>
                            <span><i class="fas fa-tasks mr-1"></i> {{ $goal->tasks_count }} tasks</span>
                        </div>
                        <div class="border-t border-pink-900/20 pt-4 flex justify-end items-center space-x-3">
                            <a href="{{ route('goals.show', $goal->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-1.5 px-4 rounded-lg shadow transition-colors duration-300 flex items-center gap-2"><i class="fas fa-eye"></i> View Details</a>
                            @if(!$goal->isFinished())
                                <a href="{{ route('goals.edit', $goal->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-1.5 px-4 rounded-lg shadow transition-colors duration-300">
                                    <i class="fas fa-edit mr-2"></i>Edit</a>
                            @endif
                            <form action="{{ route('goals.destroy', $goal->id) }}" method="POST" class="inline" id="delete-goal-form-{{ $goal->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="showDeleteConfirmation('delete-goal-form-{{ $goal->id }}', '{{ addslashes($goal->title) }}', 'goal and all its tasks')" class="bg-red-500 hover:bg-red-700 text-white font-semibold py-1.5 px-4 rounded-lg shadow transition-colors duration-300">
                                    <i class="fas fa-trash mr-2"></i>Delete</button>
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
        <div class="text-center p-12 bg-gray-800 rounded-3xl shadow-xl border border-pink-500/10">
            <img src="{{ asset('img/no-goals.svg') }}" alt="No Goals" class="mx-auto h-40 mb-8">
            <h2 class="text-3xl font-bold text-pink-500 mb-2">Start Your Journey</h2>
            <p class="text-gray-300 mb-8 max-w-md mx-auto">You haven't set any goals yet. Click the button below to create your first one and start tracking your progress.</p>
            <a href="{{ route('goals.create') }}" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-bold py-3 px-6 rounded-2xl shadow-xl transform hover:scale-105 transition-transform duration-300 inline-block">
                <i class="fas fa-plus mr-2"></i> Create Your First Goal
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function showDeleteConfirmation(formId, itemTitle, type) {
    Swal.fire({
        title: 'Delete ' + (type === 'goal' ? 'Goal' : 'Data') + '?',
        html: `Are you sure you want to delete <b>"${itemTitle}"</b>?<br><span class='text-sm text-gray-400'>This action cannot be undone.</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete!',
        cancelButtonText: 'Cancel',
        background: 'linear-gradient(to top right, #1f2937, #374151)',
        customClass: {
            popup: 'rounded-2xl shadow-2xl border border-gray-700',
            title: 'text-2xl font-bold text-red-400 pt-4',
            htmlContainer: 'text-lg text-gray-300 pb-4',
            actions: 'w-full flex justify-center gap-x-4 px-4',
            confirmButton: 'bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg',
            cancelButton: 'bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg'
        },
        buttonsStyling: false,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endpush