@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="{
    progress: {{ $goal->progress_percent }},
    status: '{{ $goal->status }}',
    updateStatus(value) {
        if (value == 100) {
            this.status = 'completed';
        } else if (value > 0) {
            this.status = 'in_progress';
        } else {
            this.status = 'not_started';
        }
    }
}">
    <div class="mb-6">
        <a href="{{ route('goals.index') }}" onclick="showLoading('Memuat halaman goals...', 'Mohon tunggu sebentar')" class="text-pink-500 hover:text-pink-700 font-semibold transition-colors duration-300 flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back to All Goals
        </a>
    </div>
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-xl" role="alert">
            <p class="font-bold">{{ session('error') }}</p>
        </div>
    @endif
    
    <div class="bg-gray-800 rounded-3xl shadow-xl overflow-hidden mb-8 border border-pink-500/10">
        <div class="p-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start mb-6">
                <div class="mb-4 md:mb-0">
                    <span class="text-xs font-semibold px-3 py-1 rounded-full mb-3 inline-block" style="background-color: {{ $goal->category->color }}20; color: {{ $goal->category->color }};">{{ $goal->category->name }}</span>
                    <h1 class="text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent">{{ $goal->title }}</h1>
                    <p class="text-gray-300 mt-2 max-w-2xl">{{ $goal->description }}</p>
                </div>
                <div class="flex space-x-3">
                    @if($goal->isCompleted() && !$goal->isFinished())
                        <button type="button" onclick="showFinishGoalConfirmation('{{ $goal->id }}', '{{ addslashes($goal->title) }}')" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-5 rounded-xl shadow-md transform hover:scale-105 transition-transform duration-300 flex items-center gap-2">
                            <i class="fas fa-check-circle"></i> Finish Goal
                        </button>
                        <form id="finish-goal-form-{{ $goal->id }}" action="{{ route('goals.finish', $goal->id) }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @endif
                    @if($goal->isFinished())
                        @if($goal->achievements->count() > 0)
                            <a href="{{ route('achievements.show', $goal->achievements->first()->id) }}" onclick="showLoading('Memuat sertifikat...', 'Mohon tunggu sebentar')" class="bg-gradient-to-r from-yellow-500 to-yellow-700 hover:from-yellow-600 hover:to-yellow-800 text-white font-bold py-2 px-5 rounded-xl shadow-md transform hover:scale-105 transition-transform duration-300 flex items-center gap-2">
                                <i class="fas fa-certificate"></i> View Certificate
                            </a>
                        @endif
                    @endif
                    @if(!$goal->isFinished())
                        <a href="{{ route('goals.edit', $goal->id) }}" onclick="showLoading('Memuat halaman edit...', 'Mohon tunggu sebentar')" class="bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-2 px-5 rounded-xl shadow-md transform hover:scale-105 transition-transform duration-300">Edit</a>
                    @endif
                    <form action="{{ route('goals.destroy', $goal->id) }}" method="POST" class="inline" id="delete-goal-form-{{ $goal->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="showDeleteConfirmation('delete-goal-form-{{ $goal->id }}', '{{ addslashes($goal->title) }}', 'goal')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-5 rounded-xl shadow-md transform hover:scale-105 transition-transform duration-300">Delete</button>
                    </form>
                </div>
            </div>
            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8 text-center">
                <div class="bg-gray-900 p-4 rounded-xl border border-pink-500/10">
                    <p class="text-sm text-pink-200">Status</p>
                    <p class="text-lg font-bold text-pink-400" :class="{
                        'text-green-400': status === 'finished',
                        'text-blue-400': status === 'completed',
                        'text-yellow-400': status === 'in_progress',
                        'text-gray-400': status === 'not_started'
                    }" x-text="status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())">{{ $goal->formatted_status }}</p>
                </div>
                <div class="bg-gray-900 p-4 rounded-xl border border-pink-500/10">
                    <p class="text-sm text-pink-200">Target Date</p>
                    <p class="text-lg font-bold text-white">{{ $goal->end_date ? $goal->end_date->format('M d, Y') : 'Not Set' }}</p>
                </div>
                <div class="bg-gray-900 p-4 rounded-xl border border-pink-500/10">
                    <p class="text-sm text-pink-200">Tasks</p>
                    <p class="text-lg font-bold text-white">{{ $goal->tasks->where('is_completed', true)->count() }} / {{ $goal->tasks->count() }}</p>
                </div>
                <div class="bg-gray-900 p-4 rounded-xl border border-pink-500/10">
                    <p class="text-sm text-pink-200">Days Left</p>
                    <p class="text-lg font-bold text-white">
                        @php
                            $daysLeft = null;
                            if ($goal->start_date && $goal->end_date) {
                                $today = \Carbon\Carbon::today();
                                $start = \Carbon\Carbon::parse($goal->start_date);
                                $end = \Carbon\Carbon::parse($goal->end_date);
                                $total = $start->diffInDays($end, false);
                                $elapsed = $start->diffInDays($today, false);
                                $daysLeft = max($total - $elapsed, 0);
                            }
                        @endphp
                        @if(!is_null($daysLeft))
                            {{ $daysLeft }}
                        @else
                            -
                        @endif
                    </p>
                </div>
            </div>
            <!-- Progress Update -->
            <div class="bg-gray-900 border-2 border-gray-800 rounded-xl p-6 mb-8 relative">
                <h3 class="text-xl font-bold text-pink-700 mb-4">Progress</h3>
                <span class="absolute right-6 top-6 text-xs font-bold px-4 py-1 rounded-md shadow-sm
                    @if($goal->status == 'finished') bg-green-100 text-green-700
                    @elseif($goal->status == 'completed') bg-blue-100 text-blue-700
                    @elseif($goal->status == 'in_progress') bg-yellow-100 text-yellow-700
                    @else bg-gray-200 text-gray-700 @endif">
                    {{ ucfirst(str_replace('_', ' ', $goal->status)) }}
                </span>
                <div class="w-full flex flex-col gap-2 relative">
                    <div class="relative w-full h-6 bg-gray-300 rounded-md overflow-hidden shadow-inner">
                        <div class="absolute left-0 top-0 h-full bg-gradient-to-r from-pink-500 to-pink-700" style="width: {{ $goal->progress_percent }}%; transition: width 0.5s;"></div>
                        <!-- (Opsional) Teks di tengah bar -->
                        <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white font-bold text-base drop-shadow">
                        {{ $goal->progress_percent }}%
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Tasks and Progress History Tabs -->
    <div x-data="{ tab: 'tasks' }">
        <div class="border-b border-pink-900/20 mb-6">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button @click="tab = 'tasks'" :class="{ 'border-pink-500 text-pink-500': tab === 'tasks', 'border-transparent text-gray-400 hover:text-pink-400 hover:border-pink-300': tab !== 'tasks' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg">Tasks ({{ $goal->tasks->count() }})</button>
                <button @click="tab = 'history'" :class="{ 'border-pink-500 text-pink-500': tab === 'history', 'border-transparent text-gray-400 hover:text-pink-400 hover:border-pink-300': tab !== 'history' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg">Progress History</button>
            </nav>
        </div>
        <!-- Tasks Section -->
        <div x-show="tab === 'tasks'">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-pink-500">Tasks</h2>
                @if($goal->canAddTasks())
                    <a href="{{ route('tasks.create', ['goal_id' => $goal->id]) }}" onclick="showLoading('Memuat halaman tambah task...', 'Mohon tunggu sebentar')" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-bold py-2 px-5 rounded-xl shadow-md transform hover:scale-105 transition-transform duration-300 flex items-center gap-2">
                        <i class="fas fa-plus"></i> Add Task
                    </a>
                @else
                    <div class="bg-gray-600 text-gray-300 px-4 py-2 rounded-xl flex items-center gap-2">
                        <i class="fas fa-lock"></i> Goal Finished - No New Tasks
                    </div>
                @endif
            </div>
            @if($goal->tasks->count() > 0)
                @include('tasks._list', ['tasks' => $goal->tasks])
            @else
                <div class="bg-gray-800 rounded-xl shadow-md p-12 text-center border border-pink-500/10">
                    <i class="fas fa-check-square text-6xl text-pink-200 mb-4"></i>
                    <h3 class="text-xl font-semibold text-pink-400">No Tasks Yet</h3>
                    <p class="text-pink-200 mt-2">Add tasks to this goal to start making progress.</p>
                </div>
            @endif
        </div>
        <!-- Progress History Section -->
        <div x-show="tab === 'history'" style="display: none;">
            <h2 class="text-3xl font-bold text-pink-500 mb-6">Progress History</h2>
            <div class="bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-pink-500/10">
                @if($progressHistory->count() > 0)
                    <ul class="divide-y divide-pink-900/20">
                        @foreach($progressHistory as $record)
                            <li class="p-6 hover:bg-gray-900 transition-colors duration-200">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-lg font-semibold text-pink-400">
                                            @if($record->progressable_type === 'App\\Models\\Task')
                                                Task "<span class="font-bold text-pink-500">{{ $record->progressable->title }}</span>" completed.
                                            @else
                                                Goal progress updated to <span class="font-bold text-pink-500">{{ $record->progress_value }}%</span>.
                                            @endif
                                        </p>
                                        <p class="text-sm text-pink-200 mt-1">{{ $record->created_at->format('M d, Y \\a\\t h:i A') }}</p>
                                        @if($record->note)
                                            <p class="text-pink-100 mt-2 pl-4 border-l-2 border-pink-200">{{ $record->note }}</p>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <span class="text-sm font-semibold px-3 py-1 rounded-full
                                            @if($record->progressable_type === 'App\\Models\\Task') bg-pink-100 text-pink-700
                                            @else bg-pink-200 text-pink-800 @endif">
                                            @if($record->progressable_type === 'App\\Models\\Task') Task Completed
                                            @else Manual Update @endif
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="p-12 text-center">
                        <i class="fas fa-history text-6xl text-pink-200 mb-4"></i>
                        <h3 class="text-xl font-semibold text-pink-400">No History Yet</h3>
                        <p class="text-pink-200 mt-2">Progress updates for this goal will appear here.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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
            // Show loading screen before submitting
            showLoading('Menghapus goal...', 'Mohon tunggu sebentar');
            document.getElementById(formId).submit();
        }
    });
}

function showFinishGoalConfirmation(goalId, goalTitle) {
    Swal.fire({
        title: 'Finish Goal?',
        html: `
            <div class="text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-trophy text-2xl text-white"></i>
                </div>
                <p class="text-lg text-gray-300 mb-4">Are you sure you want to finish this goal?</p>
                <div class="bg-gray-700 rounded-lg p-4 mb-4">
                    <p class="text-white font-semibold">"${goalTitle}"</p>
                </div>
                <div class="text-sm text-gray-400 space-y-2">
                    <p><i class="fas fa-info-circle text-blue-400"></i> This goal will be marked as <strong>Finished</strong></p>
                    <p><i class="fas fa-lock text-red-400"></i> You won't be able to add new tasks to this goal</p>
                    <p><i class="fas fa-check-circle text-green-400"></i> All existing tasks will remain accessible</p>
                    <p><i class="fas fa-certificate text-yellow-400"></i> An achievement certificate will be created</p>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Yes, Finish Goal!',
        cancelButtonText: 'Cancel',
        background: 'linear-gradient(to top right, #1f2937, #374151)',
        customClass: {
            popup: 'rounded-2xl shadow-2xl border border-gray-700',
            title: 'text-2xl font-bold text-green-400 pt-4',
            htmlContainer: 'text-lg text-gray-300 pb-4',
            actions: 'w-full flex justify-center gap-x-4 px-4',
            confirmButton: 'bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg',
            cancelButton: 'bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg'
        },
        buttonsStyling: false,
        focusCancel: true,
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading screen before submitting
            showLoading('Menyelesaikan goal...', 'Membuat sertifikat achievement...');
            document.getElementById('finish-goal-form-' + goalId).submit();
        }
    });
}
</script>
@endpush