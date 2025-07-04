@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold">Create Progress Record</h1>
            <a href="{{ route('progress.index') }}" class="text-blue-500 hover:text-blue-700">Back to Progress History</a>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('progress.store') }}" method="POST">
                @csrf
                
                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="mb-4">
                    <label for="record_type" class="block text-gray-700 font-medium mb-2">Record Type</label>
                    <select name="record_type" id="record_type" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required onchange="toggleRecordType()">
                        <option value="">Select record type</option>
                        <option value="goal" {{ old('record_type') == 'goal' ? 'selected' : '' }}>Goal Progress</option>
                        <option value="task" {{ old('record_type') == 'task' ? 'selected' : '' }}>Task Status</option>
                    </select>
                </div>
                
                <div id="goal_section" class="mb-4" style="display: {{ old('record_type') == 'goal' ? 'block' : 'none' }}">
                    <label for="goal_id" class="block text-gray-700 font-medium mb-2">Goal</label>
                    <select name="goal_id" id="goal_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="">Select a goal</option>
                        @foreach($goals as $goal)
                            <option value="{{ $goal->id }}" {{ old('goal_id') == $goal->id ? 'selected' : '' }}>
                                {{ $goal->title }} ({{ $goal->category->name }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div id="task_section" class="mb-4" style="display: {{ old('record_type') == 'task' ? 'block' : 'none' }}">
                    <label for="task_id" class="block text-gray-700 font-medium mb-2">Task</label>
                    <select name="task_id" id="task_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="">Select a task</option>
                        @foreach($tasks as $task)
                            <option value="{{ $task->id }}" {{ old('task_id') == $task->id ? 'selected' : '' }}>
                                {{ $task->title }} ({{ $task->goal->title }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div id="percentage_section" class="mb-4" style="display: {{ old('record_type') == 'goal' ? 'block' : 'none' }}">
                    <label for="progress_value" class="block text-gray-700 font-medium mb-2">Progress Percentage</label>
                    <input type="range" name="progress_value" id="progress_value" min="0" max="100" step="5" value="{{ old('progress_value', 0) }}" class="w-full" oninput="progressValue.innerText = this.value + '%'">
                    <div class="text-right text-gray-500"><span id="progressValue">{{ old('progress_value', 0) }}%</span></div>
                </div>
                
                <div id="status_section" class="mb-4" style="display: {{ old('record_type') == 'goal' ? 'block' : 'none' }}">
                    <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
                    <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="not_started" {{ old('status') == 'not_started' ? 'selected' : '' }}>Not Started</option>
                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                
                <div id="completed_section" class="mb-4" style="display: {{ old('record_type') == 'task' ? 'block' : 'none' }}">
                    <label class="flex items-center">
                        <input type="checkbox" name="completed" value="1" {{ old('completed') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-gray-700">Mark as completed</span>
                    </label>
                </div>
                
                <div class="mb-4">
                    <label for="note" class="block text-gray-700 font-medium mb-2">Notes</label>
                    <textarea name="note" id="note" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('note') }}</textarea>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Create Progress Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleRecordType() {
        const recordType = document.getElementById('record_type').value;
        
        // Hide all sections first
        document.getElementById('goal_section').style.display = 'none';
        document.getElementById('task_section').style.display = 'none';
        document.getElementById('percentage_section').style.display = 'none';
        document.getElementById('status_section').style.display = 'none';
        document.getElementById('completed_section').style.display = 'none';
        
        // Show relevant sections based on record type
        if (recordType === 'goal') {
            document.getElementById('goal_section').style.display = 'block';
            document.getElementById('percentage_section').style.display = 'block';
            document.getElementById('status_section').style.display = 'block';
        } else if (recordType === 'task') {
            document.getElementById('task_section').style.display = 'block';
            document.getElementById('completed_section').style.display = 'block';
        }
    }
    
    // Update progress value display when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        const progressInput = document.getElementById('progress_value');
        if (progressInput) {
            progressValue.innerText = progressInput.value + '%';
        }
    });
</script>
@endsection