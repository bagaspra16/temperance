@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ $goal_url ?? route('tasks.index') }}" class="text-pink-400 hover:text-pink-500 font-semibold transition-colors duration-300">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
    </div>

    <div class="bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
        <div class="p-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start mb-6">
                <div class="flex items-start space-x-6">
                    <!-- Enhanced Task Status Icon -->
                    <div class="relative group">
                        <div class="flex-shrink-0 h-16 w-16 rounded-2xl border-3 flex items-center justify-center transition-all duration-500 transform group-hover:scale-110 group-hover:rotate-3 
                            @if($task->is_completed)
                                bg-gradient-to-br from-green-400 to-green-600 border-green-300 text-white shadow-lg shadow-green-500/30
                            @elseif($task->status === 'in_progress')
                                bg-gradient-to-br from-blue-400 to-blue-600 border-blue-300 text-white shadow-lg shadow-blue-500/30 animate-pulse
                            @else
                                bg-gradient-to-br from-yellow-400 to-orange-500 border-yellow-300 text-white shadow-lg shadow-yellow-500/30 hover:from-orange-400 hover:to-red-500
                            @endif
                            focus:outline-none focus:ring-4 focus:ring-offset-2 focus:ring-pink-500">
                            
                            @if($task->is_completed)
                                <i class="fas fa-check text-2xl transform group-hover:scale-125 transition-transform duration-300"></i>
                            @elseif($task->status === 'in_progress')
                                <i class="fas fa-play text-2xl transform group-hover:scale-125 transition-transform duration-300 ml-1"></i>
                            @else
                                <i class="fas fa-clock text-2xl transform group-hover:scale-125 transition-transform duration-300"></i>
                            @endif
                        </div>
                        
                        <!-- Floating Status Indicator -->
                        <div class="absolute -top-2 -right-2 w-5 h-5 rounded-full border-2 border-white 
                            @if($task->is_completed) bg-green-500 @elseif($task->status === 'in_progress') bg-blue-500 @else bg-yellow-500 @endif
                            shadow-lg transform scale-0 group-hover:scale-100 transition-transform duration-300">
                        </div>
                        
                        <!-- Priority Indicator -->
                        @if($task->priority === 'high')
                            <div class="absolute -bottom-2 -right-2 w-6 h-6 rounded-full bg-red-500 border-2 border-white shadow-lg flex items-center justify-center transform scale-0 group-hover:scale-100 transition-transform duration-300">
                                <i class="fas fa-exclamation-triangle text-[8px] sm:text-[10px] text-white"></i>
                            </div>
                        @elseif($task->priority === 'medium')
                            <div class="absolute -bottom-2 -right-2 w-6 h-6 rounded-full bg-yellow-500 border-2 border-white shadow-lg flex items-center justify-center transform scale-0 group-hover:scale-100 transition-transform duration-300">
                                <i class="fas fa-minus text-[8px] sm:text-[10px] text-white"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex-1">
                        <h1 class="text-4xl font-bold text-gray-100 {{ $task->is_completed ? 'line-through text-gray-500' : '' }} group">
                            <span class="relative">
                                {{ $task->title }}
                            </span>
                        </h1>
                        <p class="text-gray-400 mt-3 max-w-2xl text-lg leading-relaxed">{{ $task->description }}</p>
                    </div>
                </div>
                <div class="flex space-x-3 mt-4 md:mt-0">
                    @if(!$task->is_completed)
                        <!-- Task Action Buttons -->
                        @if($task->status === 'pending')
                            <form action="{{ route('tasks.start', $task->id) }}" method="POST" class="inline" id="start-task-form-{{ $task->id }}">
                                @csrf
                                <button type="button" onclick="showStartConfirmation('{{ $task->id }}', '{{ addslashes($task->title) }}')" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-5 rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300">
                                    <i class="fas fa-play mr-2"></i>Start Task
                                </button>
                            </form>
                            <button type="button" onclick="showForceCompleteModal()" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-5 rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300">
                                <i class="fas fa-check mr-2"></i>Complete
                            </button>
                        @elseif($task->status === 'in_progress')
                            <form action="{{ route('tasks.finish', $task->id) }}" method="POST" class="inline" id="finish-task-form-{{ $task->id }}">
                                @csrf
                                <button type="button" onclick="showCompleteConfirmation('{{ $task->id }}', '{{ addslashes($task->title) }}')" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-5 rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300">
                                    <i class="fas fa-check mr-2"></i>Mark as Completed
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('tasks.edit', $task->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-5 rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-edit mr-2"></i>Edit</a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline" id="delete-task-form-{{ $task->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="showDeleteConfirmation('delete-task-form-{{ $task->id }}', '{{ addslashes($task->title) }}', 'task')" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-5 rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300">
                                <i class="fas fa-trash mr-2"></i>Delete</button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Details -->
            <div class="border-t border-gray-700 pt-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Left Column -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-300 mb-4">Details</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1 text-md font-semibold px-3 py-1 rounded-full inline-block {{ $task->status_badge_class }}">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </dd>
                            </div>
                            
                            @if($task->start_time)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Started At</dt>
                                <dd class="mt-1 text-md text-gray-100">{{ $task->start_time->format('M d, Y \a\t h:i A') }}</dd>
                            </div>
                            @endif
                            
                            @if($task->completed_time)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Completed At</dt>
                                <dd class="mt-1 text-md text-gray-100">{{ $task->completed_time->format('M d, Y \a\t h:i A') }}</dd>
                            </div>
                            @endif
                            
                            @if($task->duration_minutes && $task->duration_minutes > 0)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Duration</dt>
                                <dd class="mt-1 text-md text-gray-100 font-semibold text-green-400">{{ $task->formatted_duration }}</dd>
                            </div>
                            @endif
                            
                            @if($task->force_complete_reason)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Force Complete Reason</dt>
                                <dd class="mt-1 text-md text-gray-100 italic">"{{ $task->force_complete_reason }}"</dd>
                            </div>
                            @endif
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Due Date</dt>
                                <dd class="mt-1 text-md text-gray-100 {{ $task->due_date && $task->due_date->isPast() && !$task->is_completed ? 'text-red-400 font-bold' : '' }}">
                                    {{ $task->due_date ? $task->due_date->format('M d, Y') : 'Not Set' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Priority</dt>
                                <dd class="mt-1 text-md text-gray-100 capitalize">{{ $task->priority }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Right Column -->
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-semibold text-gray-300 mb-4">Related Goal</h3>
                        <div class="bg-gray-900 hover:bg-gray-700/50 rounded-xl p-6 transition-colors duration-200">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-semibold" style="color: {{ $task->goal->category->color }}">{{ $task->goal->category->name }}</p>
                                    <a href="{{ route('goals.show', $task->goal->id) }}" class="text-xl font-bold text-gray-100 hover:text-pink-400">{{ $task->goal->title }}</a>
                                </div>
                                <a href="{{ route('goals.show', $task->goal->id) }}" class="text-pink-400 hover:text-pink-500 font-semibold">View Goal <i class="fas fa-arrow-right ml-1"></i></a>
                            </div>
                            <div class="mt-4">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-sm font-medium text-gray-400">Goal Progress</span>
                                    <span class="text-sm font-bold text-pink-400">{{ $task->goal->progress_percent }}%</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2.5">
                                    <div class="bg-pink-600 h-2.5 rounded-full" style="width: {{ $task->goal->progress_percent }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Force Complete Modal -->
<div id="forceCompleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-gray-800 rounded-2xl p-8 max-w-md w-full mx-4">
        <h3 class="text-2xl font-bold text-gray-100 mb-4">Complete Task Directly</h3>
        <p class="text-gray-400 mb-6">Please provide a reason why you're completing this task directly from pending status:</p>
        
        <form action="{{ route('tasks.force-complete', $task->id) }}" method="POST">
            @csrf
            <div class="mb-6">
                <textarea 
                    name="force_complete_reason" 
                    rows="4" 
                    class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                    placeholder="Example: This task is no longer relevant due to priority changes..."
                    required
                >{{ old('force_complete_reason') }}</textarea>
                @error('force_complete_reason')
                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex space-x-3">
                <button type="button" onclick="hideForceCompleteModal()" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-4 rounded-lg transition-colors duration-300">
                    Cancel
                </button>
                <button type="submit" class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded-lg transition-colors duration-300">
                    Complete Task
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showForceCompleteModal() {
    document.getElementById('forceCompleteModal').classList.remove('hidden');
}

function hideForceCompleteModal() {
    document.getElementById('forceCompleteModal').classList.add('hidden');
}

function showCompleteConfirmation(taskId, taskTitle) {
    Swal.fire({
        title: 'Complete Task?',
        html: `Task <strong>"${taskTitle}"</strong> will be marked as completed.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Complete!',
        cancelButtonText: 'Cancel',
        background: 'linear-gradient(to top right, #1f2937, #374151)',
        customClass: {
            popup: 'rounded-2xl shadow-2xl border border-gray-700',
            title: 'text-2xl font-bold text-pink-400 pt-4',
            htmlContainer: 'text-lg text-gray-300 pb-4',
            actions: 'w-full flex justify-center gap-x-4 px-4',
            confirmButton: 'bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg',
            cancelButton: 'bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('finish-task-form-' + taskId).submit();
        }
    });
}

function showStartConfirmation(taskId, taskTitle) {
    Swal.fire({
        title: 'Start Task?',
        html: `Task <strong>"${taskTitle}"</strong> will be started and status will change to <b>in progress</b>.`,
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Yes, Start!',
        cancelButtonText: 'Cancel',
        background: 'linear-gradient(to top right, #1f2937, #374151)',
        customClass: {
            popup: 'rounded-2xl shadow-2xl border border-gray-700',
            title: 'text-2xl font-bold text-blue-400 pt-4',
            htmlContainer: 'text-lg text-gray-300 pb-4',
            actions: 'w-full flex justify-center gap-x-4 px-4',
            confirmButton: 'bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg',
            cancelButton: 'bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('start-task-form-' + taskId).submit();
        }
    });
}

function showDeleteConfirmation(formId, itemTitle, type) {
    Swal.fire({
        title: 'Delete ' + (type === 'task' ? 'Task' : 'Data') + '?',
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

// Show modal if there are validation errors
@if($errors->has('force_complete_reason') || session('show_force_complete_modal'))
    document.addEventListener('DOMContentLoaded', function() {
        showForceCompleteModal();
    });
@endif

// Close modal when clicking outside
document.getElementById('forceCompleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideForceCompleteModal();
    }
});
</script>
@endpush