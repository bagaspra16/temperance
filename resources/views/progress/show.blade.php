@extends('layouts.app')

@section('content')
<div class="container mx-auto px-3 sm:px-4 py-6 sm:py-8">
    <div class="mb-4 sm:mb-6">
        <a href="{{ route('progress.index') }}" class="text-blue-600 hover:text-pink-600 font-semibold transition-colors duration-300 text-xs sm:text-sm md:text-base">
            <i class="fas fa-arrow-left mr-1 sm:mr-2 text-xs sm:text-sm"></i> Back to Progress History
        </a>
    </div>

    <div class="bg-gray-800/70 rounded-2xl shadow-lg overflow-hidden">
        <div class="p-4 sm:p-6 md:p-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start mb-6 sm:mb-8 pb-4 sm:pb-6 border-b border-gray-500">
                <div>
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow mb-1 sm:mb-2">Progress Record</h1>
                    <p class="text-gray-400 text-xs sm:text-sm"><i class="far fa-clock mr-1 sm:mr-2"></i>Recorded on {{ $progress->created_at->format('M d, Y \a\t h:i A') }}</p>
                </div>
                <form action="{{ route('progress.destroy', $progress->id) }}" method="POST" class="inline mt-4 md:mt-0" id="delete-progress-form-{{ $progress->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="showDeleteConfirmation('delete-progress-form-{{ $progress->id }}', 'this progress record', 'progress record')" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1.5 sm:py-2 px-3 sm:px-5 rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300 text-xs sm:text-sm">
                        <i class="fas fa-trash-alt mr-1 sm:mr-2"></i>Delete Record
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 md:gap-8">
                <!-- Left Column: Record Details -->
                <div class="bg-gray-800/80 rounded-xl p-4 sm:p-6 border border-gray-500">
                    <h2 class="text-xl sm:text-2xl font-bold text-pink-500 mb-4 sm:mb-6">Record Details</h2>
                    <dl class="space-y-4 sm:space-y-6">
                        @if($progress->percentage !== null)
                        <div>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 flex items-center"><i class="fas fa-chart-line mr-1 sm:mr-2 text-green-500"></i>Progress Change</dt>
                            <dd class="mt-1 text-lg sm:text-xl md:text-2xl font-bold text-gray-900">Percentage set to <span class="text-green-600">{{ $progress->percentage }}%</span></dd>
                        </div>
                        @endif

                        @if($progress->status)
                        <div>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 flex items-center"><i class="fas fa-tag mr-1 sm:mr-2 text-purple-500"></i>Status Change</dt>
                            <dd class="mt-1">
                                <span class="text-sm sm:text-lg font-semibold px-2 sm:px-4 py-0.5 sm:py-1 rounded-full inline-block {{ $progress->status_classes }}">
                                    {{ $progress->status_formatted }}
                                </span>
                            </dd>
                        </div>
                        @endif

                        @if($progress->note)
                        <div>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 flex items-center"><i class="far fa-sticky-note mr-1 sm:mr-2 text-yellow-500"></i>Notes</dt>
                            <dd class="mt-2 text-gray-400 bg-gray-700 p-3 sm:p-4 rounded-md border-l-4 border-yellow-400 italic text-xs sm:text-sm">"{{ $progress->note }}"</dd>
                        </div>
                        @endif
                    </dl>
                </div>

                <!-- Right Column: Related Item -->
                <div class="bg-gray-800/80 rounded-xl p-4 sm:p-6 border border-gray-500">
                    <h2 class="text-xl sm:text-2xl font-bold text-pink-500 mb-4 sm:mb-6">Related Item</h2>
                    @if($progress->goal)
                        <a href="{{ route('goals.show', $progress->goal->id) }}" class="block hover:bg-gray-800/40 p-3 sm:p-4 rounded-lg border border-gray-700/40 transition-all duration-300 backdrop-blur-sm hover:shadow-lg">
                            @if($progress->goal->category)
                                <p class="text-xs sm:text-sm font-semibold" style="color: {{ $progress->goal->category->color }};">{{ $progress->goal->category->name }}</p>
                            @else
                                <p class="text-xs sm:text-sm font-semibold text-gray-500">Uncategorized</p>
                            @endif
                            <h3 class="text-lg sm:text-xl font-bold text-gray-800">{{ $progress->goal->title }}</h3>
                            <p class="text-xs sm:text-sm text-gray-500 mt-1">Goal</p>
                            <div class="mt-3 sm:mt-4">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-xs sm:text-sm font-medium text-gray-700">Current Progress</span>
                                    <span class="text-xs sm:text-sm font-bold text-blue-600">{{ $progress->goal->progress_percent }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 sm:h-2.5">
                                    <div class="bg-blue-600 h-2 sm:h-2.5 rounded-full" style="width: {{ $progress->goal->progress_percent }}%;"></div>
                                </div>
                            </div>
                        </a>
                    @elseif($progress->task)
                        <a href="{{ route('tasks.show', $progress->task->id) }}" class="block hover:bg-gray-800/40 p-3 sm:p-4 rounded-lg border border-gray-700/40 transition-all duration-300 backdrop-blur-sm hover:shadow-lg">
                            <h3 class="text-lg sm:text-xl font-bold text-white hover:text-pink-400">{{ $progress->task->title }}</h3>
                            @if($progress->task->goal)
                                <p class="text-xs sm:text-sm text-gray-500 mt-1">Task for goal: "{{ $progress->task->goal->title }}"</p>
                            @else
                                <p class="text-xs sm:text-sm text-gray-500 mt-1">Task (Goal deleted)</p>
                            @endif
                            <div class="mt-3 sm:mt-4">
                                <p class="text-xs sm:text-sm font-medium text-gray-700">Status: 
                                    <span class="font-bold {{ $progress->task->is_completed ? 'text-green-600' : 'text-yellow-600' }}">
                                        {{ $progress->task->is_completed ? 'Completed' : 'Pending' }}
                                    </span>
                                </p>
                            </div>
                        </a>
                    @else
                        <div class="text-center p-6 sm:p-8">
                            <i class="fas fa-question-circle text-3xl sm:text-4xl text-gray-300 mb-3 sm:mb-4"></i>
                            <p class="text-gray-500 text-xs sm:text-sm">The related item for this record could not be found. It may have been deleted.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showDeleteConfirmation(formId, itemTitle, type) {
    Swal.fire({
        title: 'Delete ' + (type === 'progress' ? 'Progress' : 'Data') + '?',
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
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endpush