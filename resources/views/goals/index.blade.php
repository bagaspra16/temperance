@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow">Your Goals</h1>
            <p class="text-gray-400 text-sm sm:text-base mt-2">Set, track, and achieve your personal and professional objectives</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 w-full sm:w-auto">
            <a href="{{ route('goals.calendar') }}" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-bold py-2.5 sm:py-3 px-4 sm:px-6 rounded-xl sm:rounded-2xl shadow-xl transform hover:scale-105 transition-transform duration-300 flex items-center justify-center gap-2 text-sm sm:text-base" onclick="showLoading('Memuat calendar view...', 'Mohon tunggu sebentar')">
                <i class="fas fa-calendar-alt"></i> <span class="hidden sm:inline">Calendar View</span><span class="sm:hidden">Calendar</span>
            </a>
            <a href="{{ route('goals.create') }}" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-bold py-2.5 sm:py-3 px-4 sm:px-6 rounded-xl sm:rounded-2xl shadow-xl transform hover:scale-105 transition-transform duration-300 flex items-center justify-center gap-2 text-sm sm:text-base" onclick="showLoading('Memuat halaman...', 'Mohon tunggu sebentar')">
                <i class="fas fa-plus"></i> <span class="hidden sm:inline">Add New Goal</span><span class="sm:hidden">New Goal</span>
            </a>
        </div>
    </div>

    @if($goals->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
            @foreach($goals as $goal)
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl shadow-lg overflow-hidden border border-gray-600/70 transform hover:-translate-y-2 hover:bg-gray-800/40 transition-all duration-300 ease-in-out">
                    <div class="p-4 sm:p-6">
                        <div class="flex justify-between items-start mb-3 sm:mb-4">
                            <div>
                                <span class="text-xs font-semibold px-2 sm:px-3 py-1 rounded-full text-xs" style="background-color: {{ $goal->category->color }}20; color: {{ $goal->category->color }};">{{ $goal->category->name }}</span>
                            </div>
                            <span class="text-xs font-semibold px-2 sm:px-3 py-1 rounded-full 
                                @if($goal->status == 'completed') bg-pink-100 text-pink-700
                                @elseif($goal->status == 'in_progress') bg-pink-200 text-pink-800
                                @else bg-gray-700 text-gray-200 @endif">
                                {{ $goal->formatted_status }}
                            </span>
                        </div>
                        <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-white mb-2">{{ $goal->title }}</h2>
                        <p class="text-gray-300 mb-4 sm:mb-5 h-12 text-sm sm:text-base">{{ Str::limit($goal->description, 100) }}</p>
                        <div class="mb-3 sm:mb-4">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs sm:text-sm font-medium text-pink-200">Progress</span>
                                <span class="text-xs sm:text-sm font-bold text-pink-400">{{ $goal->progress_percent }}%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2 sm:h-2.5">
                                <div class="bg-gradient-to-r from-pink-500 to-pink-700 h-2 sm:h-2.5 rounded-full" style="width: {{ $goal->progress_percent }}%;"></div>
                            </div>
                        </div>
                        <div class="flex justify-between items-center text-xs text-gray-400 mb-4 sm:mb-6">
                            <span><i class="far fa-calendar-alt mr-1"></i> {{ $goal->end_date ? $goal->end_date->format('M d, Y') : 'No Target' }}</span>
                            <span><i class="fas fa-tasks mr-1"></i> {{ $goal->tasks_count }} tasks</span>
                        </div>
                        <div class="border-t border-pink-900/20 pt-3 sm:pt-4 flex flex-col sm:flex-row gap-2 sm:gap-3">
                            <a href="{{ route('goals.show', $goal->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-3 sm:px-4 rounded-lg shadow transition-colors duration-300 flex items-center justify-center gap-1 sm:gap-2 text-xs sm:text-sm" onclick="showLoading('Memuat detail...', 'Mohon tunggu sebentar')">
                                <i class="fas fa-eye"></i> <span class="hidden sm:inline">View Details</span><span class="sm:hidden">View</span>
                            </a>
                            @if(!$goal->isFinished())
                                <a href="{{ route('goals.edit', $goal->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-2 px-3 sm:px-4 rounded-lg shadow transition-colors duration-300 flex items-center justify-center gap-1 sm:gap-2 text-xs sm:text-sm" onclick="showLoading('Memuat halaman edit...', 'Mohon tunggu sebentar')">
                                    <i class="fas fa-edit"></i> <span class="hidden sm:inline">Edit</span><span class="sm:hidden">Edit</span>
                                </a>
                            @endif
                            <form action="{{ route('goals.destroy', $goal->id) }}" method="POST" class="inline" id="delete-goal-form-{{ $goal->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="showDeleteConfirmation('delete-goal-form-{{ $goal->id }}', '{{ addslashes($goal->title) }}', 'goal and all its tasks')" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-3 sm:px-4 rounded-lg shadow transition-colors duration-300 flex items-center justify-center gap-1 sm:gap-2 text-xs sm:text-sm">
                                    <i class="fas fa-trash"></i> <span class="hidden sm:inline">Delete</span><span class="sm:hidden">Delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6 sm:mt-8">
            {{ $goals->links() }}
        </div>
    @else
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl shadow-lg overflow-hidden border border-gray-600/70">
            <div class="text-center p-6 sm:p-8 lg:p-12 bg-gradient-to-br from-gray-800/30 to-gray-900/40 backdrop-blur-sm">
                <div class="w-24 h-24 sm:w-32 sm:h-32 lg:w-40 lg:h-40 bg-gradient-to-br from-pink-500/20 to-pink-700/20 rounded-full flex items-center justify-center mx-auto mb-6 sm:mb-8 border border-pink-500/30">
                    <i class="fas fa-bullseye text-3xl sm:text-4xl lg:text-5xl text-pink-400"></i>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent mb-2">Start Your Journey</h2>
                <p class="text-gray-300 mb-6 sm:mb-8 max-w-md mx-auto text-sm sm:text-base">You haven't set any goals yet. Click the button below to create your first one and start tracking your progress.</p>
                <a href="{{ route('goals.create') }}" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-bold py-2.5 sm:py-3 px-4 sm:px-6 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300 inline-flex items-center gap-2 text-sm sm:text-base" onclick="showLoading('Memuat halaman...', 'Mohon tunggu sebentar')">
                    <i class="fas fa-plus"></i> <span class="hidden sm:inline">Create Your First Goal</span><span class="sm:hidden">Create Goal</span>
                </a>
            </div>
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
            title: 'text-xl sm:text-2xl font-bold text-red-400 pt-4',
            htmlContainer: 'text-base sm:text-lg text-gray-300 pb-4',
            actions: 'w-full flex justify-center gap-x-4 px-4',
            confirmButton: 'bg-red-500 hover:bg-red-600 text-white font-bold py-2.5 sm:py-3 px-6 sm:px-8 rounded-lg shadow-lg text-sm sm:text-base',
            cancelButton: 'bg-gray-600 hover:bg-gray-700 text-white font-bold py-2.5 sm:py-3 px-6 sm:px-8 rounded-lg shadow-lg text-sm sm:text-base'
        },
        buttonsStyling: false,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            showLoading('Menghapus goal...', 'Mohon tunggu sebentar');
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endpush