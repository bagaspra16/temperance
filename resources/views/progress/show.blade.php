@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('progress.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors duration-300">
            <i class="fas fa-arrow-left mr-2"></i> Back to Progress History
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start mb-8 pb-6 border-b">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">Progress Record</h1>
                    <p class="text-gray-500"><i class="far fa-clock mr-2"></i>Recorded on {{ $progress->created_at->format('M d, Y \a\t h:i A') }}</p>
                </div>
                <form action="{{ route('progress.destroy', $progress->id) }}" method="POST" class="inline mt-4 md:mt-0" id="delete-progress-form-{{ $progress->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="showDeleteConfirmation('delete-progress-form-{{ $progress->id }}', 'this progress record', 'progress record')" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-5 rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-trash-alt mr-2"></i>Delete Record
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Left Column: Record Details -->
                <div class="bg-gray-50 rounded-xl p-6 border">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Record Details</h2>
                    <dl class="space-y-6">
                        @if($progress->percentage !== null)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 flex items-center"><i class="fas fa-chart-line mr-2 text-green-500"></i>Progress Change</dt>
                            <dd class="mt-1 text-2xl font-bold text-gray-900">Percentage set to <span class="text-green-600">{{ $progress->percentage }}%</span></dd>
                        </div>
                        @endif

                        @if($progress->status)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 flex items-center"><i class="fas fa-tag mr-2 text-purple-500"></i>Status Change</dt>
                            <dd class="mt-1">
                                <span class="text-lg font-semibold px-4 py-1 rounded-full inline-block {{ $progress->status_classes }}">
                                    {{ $progress->status_formatted }}
                                </span>
                            </dd>
                        </div>
                        @endif

                        @if($progress->note)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 flex items-center"><i class="far fa-sticky-note mr-2 text-yellow-500"></i>Notes</dt>
                            <dd class="mt-2 text-gray-800 bg-white p-4 rounded-md border-l-4 border-yellow-400 italic">"{{ $progress->note }}"</dd>
                        </div>
                        @endif
                    </dl>
                </div>

                <!-- Right Column: Related Item -->
                <div class="bg-gray-50 rounded-xl p-6 border">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Related Item</h2>
                    @if($progress->progressable)
                        @if($progress->progressable_type === 'App\Models\Goal')
                            @php $goal = $progress->progressable; @endphp
                            <a href="{{ route('goals.show', $goal->id) }}" class="block hover:bg-white p-4 rounded-lg border-2 border-transparent hover:border-blue-500 transition-all duration-300">
                                <p class="text-sm font-semibold" style="color: {{ $goal->category->color }};">{{ $goal->category->name }}</p>
                                <h3 class="text-xl font-bold text-gray-800">{{ $goal->title }}</h3>
                                <p class="text-sm text-gray-500 mt-1">Goal</p>
                                <div class="mt-4">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm font-medium text-gray-700">Current Progress</span>
                                        <span class="text-sm font-bold text-blue-600">{{ $goal->progress_percent }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $goal->progress_percent }}%;"></div>
                                    </div>
                                </div>
                            </a>
                        @elseif($progress->progressable_type === 'App\Models\Task')
                            @php $task = $progress->progressable; @endphp
                            <a href="{{ route('tasks.show', $task->id) }}" class="block hover:bg-white p-4 rounded-lg border-2 border-transparent hover:border-blue-500 transition-all duration-300">
                                <h3 class="text-xl font-bold text-gray-800">{{ $task->title }}</h3>
                                <p class="text-sm text-gray-500 mt-1">Task for goal: "{{ $task->goal->title }}"</p>
                                <div class="mt-4">
                                    <p class="text-sm font-medium text-gray-700">Status: 
                                        <span class="font-bold {{ $task->is_completed ? 'text-green-600' : 'text-yellow-600' }}">
                                            {{ $task->is_completed ? 'Completed' : 'Pending' }}
                                        </span>
                                    </p>
                                </div>
                            </a>
                        @endif
                    @else
                        <div class="text-center p-8">
                            <i class="fas fa-question-circle text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500">The related item for this record could not be found. It may have been deleted.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection