@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 text-pink-500">
    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Stats Cards -->
        <div class="bg-gray-800 rounded-lg shadow p-6 flex items-center justify-between transform hover:scale-105 transition-transform duration-300">
            <div>
                <h2 class="text-lg font-semibold">Total Goals</h2>
                <p class="text-3xl font-bold">{{ $totalGoals }}</p>
            </div>
            <i class="fas fa-bullseye text-4xl text-pink-500"></i>
        </div>

        <div class="bg-gray-800 rounded-lg shadow p-6 flex items-center justify-between transform hover:scale-105 transition-transform duration-300">
            <div>
                <h2 class="text-lg font-semibold">Completed Goals</h2>
                <p class="text-3xl font-bold">{{ $completedGoals }}</p>
            </div>
            <i class="fas fa-check-circle text-4xl text-green-500"></i>
        </div>

        <div class="bg-gray-800 rounded-lg shadow p-6 flex items-center justify-between transform hover:scale-105 transition-transform duration-300">
            <div>
                <h2 class="text-lg font-semibold">Total Tasks</h2>
                <p class="text-3xl font-bold">{{ $totalTasks }}</p>
            </div>
            <i class="fas fa-tasks text-4xl text-blue-500"></i>
        </div>

        <div class="bg-gray-800 rounded-lg shadow p-6 flex items-center justify-between transform hover:scale-105 transition-transform duration-300">
            <div>
                <h2 class="text-lg font-semibold">Completed Tasks</h2>
                <p class="text-3xl font-bold">{{ $completedTasks }}</p>
            </div>
            <i class="fas fa-clipboard-check text-4xl text-purple-500"></i>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Categories Section -->
        <div class="bg-gray-800 rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Your Categories</h2>
                <a href="{{ route('categories.create') }}" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-md text-sm">Add New</a>
            </div>

            @if($categories->count() > 0)
                <div class="space-y-3">
                    @foreach($categories as $category)
                        <div class="flex items-center p-3 border rounded-md border-gray-600 hover:bg-gray-700 transition-colors duration-200" style="border-left-color: {{ $category->color }}; border-left-width: 4px;">
                            <div class="flex-1">
                                <h3 class="font-medium">{{ $category->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $category->goals->count() }} goals</p>
                            </div>
                            <a href="{{ route('categories.show', $category->id) }}" class="text-pink-500 hover:text-pink-400">View</a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No categories yet. Create your first category to organize your goals.</p>
            @endif
        </div>

        <!-- Upcoming Goals Section -->
        <div class="bg-gray-800 rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Upcoming Goals</h2>
                <a href="{{ route('goals.create') }}" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-md text-sm">Add New</a>
            </div>

            @if($upcomingGoals->count() > 0)
                <div class="space-y-3">
                    @foreach($upcomingGoals as $goal)
                        <div class="p-3 border rounded-md border-gray-600 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex justify-between">
                                <h3 class="font-medium">{{ $goal->title }}</h3>
                                <span class="text-sm px-2 py-1 rounded {{ $goal->status === 'completed' ? 'bg-green-500 text-white' : 'bg-yellow-500 text-white' }}">{{ ucfirst($goal->formatted_status) }}</span>
                            </div>
                            <div class="mt-2">
                                <div class="w-full bg-gray-700 rounded-full h-2.5">
                                    <div class="bg-pink-500 h-2.5 rounded-full" style="width: {{ $goal->progress_percent }}%;"></div>
                                </div>
                                <div class="flex justify-between mt-1">
                                    <span class="text-xs text-gray-400">{{ $goal->progress_percent }}% complete</span>
                                    <span class="text-xs text-gray-400">{{ $goal->end_date ? 'Due ' . $goal->end_date->format('M d, Y') : 'No end date' }}</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('goals.show', $goal->id) }}" class="text-sm text-pink-500 hover:text-pink-400">View Details</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No upcoming goals. Create your first goal to start tracking your progress.</p>
            @endif
        </div>
    </div>

    <!-- Recent Tasks Section -->
    <div class="mt-8 bg-gray-800 rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Recent Tasks</h2>
            <a href="{{ route('tasks.create') }}" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-md text-sm">Add New</a>
        </div>

        @if($recentTasks->count() > 0)
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-900">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Task</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Goal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Due Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Priority</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800 divide-y divide-gray-700">
                        @foreach($recentTasks as $task)
                            <tr class="hover:bg-gray-700 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-white">{{ $task->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-400">{{ $task->goal->title ?? 'No Goal' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-400">{{ $task->due_date ? $task->due_date->format('M d, Y') : 'No due date' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $task->status === 'completed' ? 'bg-green-500 text-white' : ($task->status === 'in_progress' ? 'bg-blue-500 text-white' : 'bg-yellow-500 text-white') }}">
                                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $task->priority === 'high' ? 'bg-red-500 text-white' : ($task->priority === 'medium' ? 'bg-yellow-500 text-white' : 'bg-green-500 text-white') }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('tasks.show', $task->id) }}" class="text-pink-500 hover:text-pink-400 mr-3">View</a>
                                    @if($task->status !== 'completed')
                                        <form action="{{ route('tasks.complete', $task->id) }}" method="POST" class="inline" id="complete-task-form-{{ $task->id }}">
                                            @csrf
                                            <button type="button" onclick="showCompleteConfirmation('{{ $task->id }}', '{{ addslashes($task->title) }}')" class="text-green-500 hover:text-green-400">Complete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">No tasks yet. Create your first task to start tracking your progress.</p>
        @endif
    </div>
</div>
@endsection
@push('scripts')
<script>
function showCompleteConfirmation(taskId, taskTitle) {
    Swal.fire({
        title: 'Are you sure?',
        html: `This will mark the task "<strong>${taskTitle}</strong>" as complete.`,
        iconHtml: '<div class="w-24 h-24 rounded-full border-4 border-pink-500 flex items-center justify-center mx-auto animate-bounce"><i class="fas fa-check-double text-5xl text-pink-500"></i></div>',
        showCancelButton: true,
        confirmButtonText: 'Yes, Complete It!',
        cancelButtonText: 'Cancel',
        background: 'linear-gradient(to top right, #1f2937, #374151)',
        reverseButtons: true,
        customClass: {
            popup: 'rounded-2xl shadow-2xl border border-gray-700',
            icon: 'no-border',
            title: 'text-3xl font-bold text-pink-400 pt-8',
            htmlContainer: 'text-lg text-gray-300 pb-4',
            actions: 'w-full flex justify-center gap-x-4 px-4',
            confirmButton: 'bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300',
            cancelButton: 'bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300'
        },
        buttonsStyling: false,
        showClass: {
            popup: 'animate__animated animate__fadeIn animate__faster'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOut animate__faster'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('complete-task-form-' + taskId).submit();
        }
    });
}
</script>
<style>
    .swal2-icon.no-border {
        border: 0;
    }
    .animate__animated {
        --animate-duration: 0.4s;
    }
</style>
@endpush