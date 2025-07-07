@if($tasks->count() > 0)
    <div class="divide-y divide-gray-200">
        @foreach($tasks as $task)
            <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <form action="{{ route('tasks.complete', $task->id) }}" method="POST" onsubmit="this.querySelector('button[type=submit]').disabled = true;">
                            @csrf
                            <button type="submit" class="flex-shrink-0 h-7 w-7 rounded-full border-2 flex items-center justify-center {{ $task->is_completed ? 'bg-blue-600 border-blue-600 text-white cursor-not-allowed' : 'border-gray-300 hover:border-blue-500' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200" {{ $task->is_completed ? 'disabled' : '' }}>
                                @if($task->is_completed)
                                    <i class="fas fa-check"></i>
                                @endif
                            </button>
                        </form>
                        <div>
                            <a href="{{ route('tasks.show', $task->id) }}" class="text-lg font-bold text-gray-800 hover:text-blue-600 {{ $task->is_completed ? 'line-through text-gray-500' : '' }}">{{ $task->title }}</a>
                            <div class="flex items-center space-x-4 text-sm text-gray-500 mt-1">
                                <span>Goal: <a href="{{ route('goals.show', $task->goal->id) }}" class="font-medium text-blue-500 hover:underline">{{ $task->goal->title }}</a></span>
                                <span class="hidden sm:inline">|</span>
                                <span class="hidden sm:inline">Category: <span class="font-medium" style="color: {{ $task->goal->category->color }};">{{ $task->goal->category->name }}</span></span>
                                @if($task->due_date)
                                    <span class="hidden md:inline">|</span>
                                    <span class="hidden md:inline {{ $task->due_date->isPast() && !$task->is_completed ? 'text-red-500 font-semibold' : '' }}"><i class="far fa-calendar-alt mr-1"></i> Due: {{ $task->due_date->format('M d, Y') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('tasks.show', $task->id) }}" class="text-gray-400 hover:text-blue-600" title="View Details"><i class="fas fa-eye"></i></a>
                        @if(!$task->is_completed)
                            <a href="{{ route('tasks.edit', $task->id) }}" class="text-gray-400 hover:text-yellow-500" title="Edit Task"><i class="fas fa-pencil-alt"></i></a>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600" title="Delete Task"><i class="fas fa-trash-alt"></i></button>
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
        <i class="fas fa-check-square text-6xl text-gray-300 mb-4"></i>
        <h2 class="text-2xl font-semibold text-gray-700 mb-2">No Tasks Yet</h2>
        <p class="text-gray-500 mb-6">Create tasks to break down your goals into manageable steps.</p>
        <a href="{{ route('tasks.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
            Create Your First Task
        </a>
    </div>
@endif