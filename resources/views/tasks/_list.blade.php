@if($tasks->count() > 0)
    <div class="divide-y divide-gray-700">
        @foreach($tasks as $task)
            <div class="p-6 hover:bg-gray-800 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-lg rounded-xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <!-- Enhanced Task Status Icon -->
                        <div class="relative group">
                            <div class="flex-shrink-0 h-12 w-12 rounded-2xl border-3 flex items-center justify-center transition-all duration-500 transform group-hover:scale-110 group-hover:rotate-3 
                                @if($task->is_completed)
                                    bg-gradient-to-br from-green-400 to-green-600 border-green-300 text-white shadow-lg shadow-green-500/30
                                @elseif($task->status === 'in_progress')
                                    bg-gradient-to-br from-blue-400 to-blue-600 border-blue-300 text-white shadow-lg shadow-blue-500/30 animate-pulse
                                @else
                                    bg-gradient-to-br from-yellow-400 to-orange-500 border-yellow-300 text-white shadow-lg shadow-yellow-500/30 hover:from-orange-400 hover:to-red-500
                                @endif
                                focus:outline-none focus:ring-4 focus:ring-offset-2 focus:ring-pink-500">
                                
                                @if($task->is_completed)
                                    <i class="fas fa-check text-lg transform group-hover:scale-125 transition-transform duration-300"></i>
                                @elseif($task->status === 'in_progress')
                                    <i class="fas fa-play text-lg transform group-hover:scale-125 transition-transform duration-300 ml-0.5"></i>
                                @else
                                    <i class="fas fa-clock text-lg transform group-hover:scale-125 transition-transform duration-300"></i>
                                @endif
                            </div>
                            
                            <!-- Floating Status Indicator -->
                            <div class="absolute -top-1 -right-1 w-4 h-4 rounded-full border-2 border-white 
                                @if($task->is_completed) bg-green-500 @elseif($task->status === 'in_progress') bg-blue-500 @else bg-yellow-500 @endif
                                shadow-lg transform scale-0 group-hover:scale-100 transition-transform duration-300">
                            </div>
                            
                            <!-- Priority Indicator -->
                            @if($task->priority === 'high')
                                <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-red-500 border-2 border-white shadow-lg flex items-center justify-center transform scale-0 group-hover:scale-100 transition-transform duration-300">
                                    <i class="fas fa-exclamation-triangle text-xs text-white"></i>
                                </div>
                            @elseif($task->priority === 'medium')
                                <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-yellow-500 border-2 border-white shadow-lg flex items-center justify-center transform scale-0 group-hover:scale-100 transition-transform duration-300">
                                    <i class="fas fa-minus text-xs text-white"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('tasks.show', $task->id) }}" class="text-lg font-bold text-gray-200 hover:text-pink-400 transition-colors duration-300 {{ $task->is_completed ? 'line-through text-gray-500' : '' }} group">
                                    <span class="relative">
                                        {{ $task->title }}
                                    </span>
                                </a>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $task->status_badge_class }} transform hover:scale-105 transition-transform duration-200">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>
                            </div>
                            <div class="flex items-center space-x-4 text-sm text-gray-400 mt-2">
                                <span class="flex items-center space-x-1">
                                    <i class="fas fa-bullseye text-pink-400"></i>
                                    <span>Goal: <a href="{{ route('goals.show', $task->goal->id) }}" class="font-medium text-pink-400 hover:underline hover:text-pink-300 transition-colors duration-200">{{ $task->goal->title }}</a></span>
                                </span>
                                <span class="hidden sm:inline text-gray-600">|</span>
                                <span class="hidden sm:inline flex items-center space-x-1">
                                    <i class="fas fa-tag" style="color: {{ $task->goal->category->color }}"></i>
                                    <span>Category: <span class="font-medium" style="color: {{ $task->goal->category->color }}">{{ $task->goal->category->name }}</span></span>
                                </span>
                                @if($task->due_date)
                                    <span class="hidden md:inline text-gray-600">|</span>
                                    <span class="hidden md:inline flex items-center space-x-1 {{ $task->due_date->isPast() && !$task->is_completed ? 'text-red-400 font-semibold' : '' }}">
                                        <i class="far fa-calendar-alt"></i>
                                        <span>Due: {{ $task->due_date->format('M d, Y') }}</span>
                                    </span>
                                @endif
                                @if($task->duration_minutes && $task->duration_minutes > 0)
                                    <span class="hidden lg:inline text-gray-600">|</span>
                                    <span class="hidden lg:inline text-green-400 flex items-center space-x-1">
                                        <i class="fas fa-clock"></i>
                                        <span>{{ $task->formatted_duration }}</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Enhanced Action Buttons -->
                    <div class="flex items-center space-x-2">
                        @if(!$task->is_completed)
                            <!-- Task Action Buttons -->
                            @if($task->status === 'pending')
                                <form action="{{ route('tasks.start', $task->id) }}" method="POST" class="inline" id="start-task-form-{{ $task->id }}">
                                    @csrf
                                    <button type="button" onclick="showStartConfirmation('{{ $task->id }}', '{{ addslashes($task->title) }}')" class="p-2 rounded-lg bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 hover:text-blue-300 transition-all duration-300 transform hover:scale-110 hover:shadow-lg" title="Start Task">
                                        <i class="fas fa-play text-sm"></i>
                                    </button>
                                </form>
                                <button type="button" onclick="showForceCompleteModal('{{ $task->id }}', '{{ addslashes($task->title) }}')" class="p-2 rounded-lg bg-green-500/10 hover:bg-green-500/20 text-green-400 hover:text-green-300 transition-all duration-300 transform hover:scale-110 hover:shadow-lg" title="Complete Directly">
                                    <i class="fas fa-check text-sm"></i>
                                </button>
                            @elseif($task->status === 'in_progress')
                                <form action="{{ route('tasks.finish', $task->id) }}" method="POST" class="inline" id="finish-task-form-{{ $task->id }}">
                                    @csrf
                                    <button type="button" onclick="showCompleteConfirmation('{{ $task->id }}', '{{ addslashes($task->title) }}')" class="p-2 rounded-lg bg-green-500/10 hover:bg-green-500/20 text-green-400 hover:text-green-300 transition-all duration-300 transform hover:scale-110 hover:shadow-lg" title="Mark as Completed">
                                        <i class="fas fa-check-double text-sm"></i>
                                    </button>
                                </form>
                            @endif
                        @endif
                        @if(!$task->is_completed)
                            <a href="{{ route('tasks.edit', $task->id) }}" class="p-2 rounded-lg bg-yellow-500/10 hover:bg-yellow-500/20 text-yellow-400 hover:text-yellow-500 transition-all duration-300 transform hover:scale-110 hover:shadow-lg" title="Edit Task">
                                <i class="fas fa-pencil-alt text-sm"></i>
                            </a>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline" id="delete-task-form-{{ $task->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="showDeleteConfirmation('delete-task-form-{{ $task->id }}', '{{ addslashes($task->title) }}', 'task')" class="p-2 rounded-lg bg-red-500/10 hover:bg-red-500/20 text-red-500 hover:text-red-400 transition-all duration-300 transform hover:scale-110 hover:shadow-lg" title="Delete Task">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if ($tasks instanceof \Illuminate\Pagination\LengthAwarePaginator)
         <div class="p-4">
            {{ $tasks->links() }}
        </div>
    @endif
@else
    <div class="text-center p-12">
        <i class="fas fa-check-square text-6xl text-gray-600 mb-4"></i>
        <h2 class="text-2xl font-semibold text-gray-300 mb-2">No Tasks Yet</h2>
        <p class="text-gray-400 mb-6">Create tasks to break down your goals into manageable steps.</p>
        <a href="{{ route('tasks.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
            Create Your First Task
        </a>
    </div>
@endif

<!-- Force Complete Modal -->
<div id="forceCompleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-gray-800 rounded-2xl p-8 max-w-md w-full mx-4">
        <h3 class="text-2xl font-bold text-gray-100 mb-4">Complete Task Directly</h3>
        <p class="text-gray-400 mb-6">Please provide a reason why you're completing this task directly from pending status:</p>
        
        <form id="forceCompleteForm" method="POST">
            @csrf
            <div class="mb-6">
                <textarea 
                    name="force_complete_reason" 
                    rows="4" 
                    class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                    placeholder="Example: This task is no longer relevant due to priority changes..."
                    required
                ></textarea>
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

@push('scripts')
<script>
function showForceCompleteModal(taskId, taskTitle) {
    const modal = document.getElementById('forceCompleteModal');
    const form = document.getElementById('forceCompleteForm');
    
    // Set the form action
    form.action = `/tasks/${taskId}/force-complete`;
    
    // Show modal
    modal.classList.remove('hidden');
}

function hideForceCompleteModal() {
    document.getElementById('forceCompleteModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('forceCompleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideForceCompleteModal();
    }
});

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
</script>
@endpush