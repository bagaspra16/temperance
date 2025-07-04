@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Progress History</h1>
    </div>
    
    @if($progress->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Goal/Task</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($progress as $record)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $record->created_at->format('M d, Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($record->goal)
                                    <div class="text-sm font-medium text-gray-900">Goal: <a href="{{ route('goals.show', $record->goal->id) }}" class="text-blue-500 hover:text-blue-700">{{ $record->goal->title }}</a></div>
                                    <div class="text-sm text-gray-500">{{ $record->goal->category->name }}</div>
                                @elseif($record->task)
                                    <div class="text-sm font-medium text-gray-900">Task: <a href="{{ route('tasks.show', $record->task->id) }}" class="text-blue-500 hover:text-blue-700">{{ $record->task->title }}</a></div>
                                    <div class="text-sm text-gray-500">{{ $record->task->goal->title }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($record->progress_value !== null)
                                    <div class="w-24 bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $record->progress_value }}%;"></div>
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $record->progress_value }}%</span>
                                @else
                                    <span class="text-sm text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($record->goal)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $record->goal->status === 'completed' ? 'bg-green-100 text-green-800' : ($record->goal->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ $record->goal->formattedStatus }}
                                    </span>
                                @elseif($record->task)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $record->task->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $record->task->status === 'completed' ? 'Completed' : 'Pending' }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('progress.show', $record->id) }}" class="text-blue-500 hover:text-blue-700 mr-3">View</a>
                                <form action="{{ route('progress.destroy', $record->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this progress record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $progress->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-500">No progress records available.</p>
            <p class="text-gray-500 mt-2">Progress records are automatically created when you update goals or complete tasks.</p>
        </div>
    @endif
</div>
@endsection