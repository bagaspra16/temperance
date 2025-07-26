<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Task;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $goals = Goal::where('user_id', Auth::id())
            ->where('status', '!=', 'abandoned')
            ->where('status', '!=', 'finished')
            ->get();
        
        return view('tasks.create', compact('goals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'goal_id' => 'required|exists:goals,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if the goal is finished
        $goal = Goal::where('user_id', Auth::id())->find($request->goal_id);
        if (!$goal || $goal->isFinished()) {
            return redirect()->back()
                ->withErrors(['goal_id' => 'Cannot add tasks to a finished goal.'])
                ->withInput();
        }

        $task = new Task($request->all());
        $task->status = 'pending';
        $task->user_id = Auth::id();
        $task->save();

        // Update goal progress after creating a new task
        $this->updateGoalProgress($task->goal_id);

        return redirect()->route('goals.show', $task->goal_id)
            ->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function show(string $id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        $progress = $task->progressRecords()->orderBy('created_at', 'desc')->get();
        
        return view('tasks.show', compact('task', 'progress'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);

        if ($task->is_completed) {
            return redirect()->route('goals.show', $task->goal_id)
                ->with('error', 'Completed tasks cannot be edited.');
        }

        $goals = Goal::where('user_id', Auth::id())
            ->where('status', '!=', 'completed')
            ->where('status', '!=', 'abandoned')
            ->get();
        
        return view('tasks.edit', compact('task', 'goals'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);

        if ($task->is_completed) {
            return redirect()->route('goals.show', $task->goal_id)
                ->with('error', 'Completed tasks cannot be edited.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'goal_id' => 'required|exists:goals,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        
        // Set completed_at timestamp if task is being marked as completed
        if ($request->status === 'completed' && !$task->is_completed) {
            $data['completed_at'] = now();
            
            // Create progress record
            $task->progressRecords()->create([
                'note' => 'Task marked as completed',
                'progress_value' => 100,
                'user_id' => Auth::id(),
                'task_id' => $task->id
            ]);
        }
        
        $task->update($data);
        
        // Update goal progress regardless of status change
        $this->updateGoalProgress($task->goal_id);

        return redirect()->route('goals.show', $task->goal_id)
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);

        $progress = Progress::where('task_id', $task->id)->get();

        $goalId = $task->goal_id;

        foreach ($progress as $p) {
            $p->delete();
        }

        $task->delete();

        // Update goal progress after task deletion
        $this->updateGoalProgress($goalId);

        return redirect()->route('goals.show', $goalId)
            ->with('success', 'Task deleted successfully.');
    }
    
    /**
     * Mark a task as completed.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsCompleted(string $id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);

        if ($task->is_completed) {
            return redirect()->back()->with('error', 'Task is already completed.');
        }

        $task->status = 'completed';
        $task->completed_at = now();
        $task->save();
        
        // Create progress record
        $task->progressRecords()->create([
            'note' => 'Task marked as completed',
            'progress_value' => 100,
            'user_id' => Auth::id(),
            'task_id' => $task->id
        ]);
        
        // Update goal progress
        $this->updateGoalProgress($task->goal_id);

        return redirect()->back()
            ->with('success', 'Task marked as completed.');
    }

    /**
     * Start a task (change status to in_progress).
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function start(string $id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);

        if (!$task->canBeStarted()) {
            return redirect()->back()->with('error', 'Task cannot be started. Status must be pending.');
        }

        $task->status = 'in_progress';
        $task->start_time = now();
        $task->save();

        // Create progress record
        $task->progressRecords()->create([
            'note' => 'Task dimulai',
            'progress_value' => 25,
            'user_id' => Auth::id(),
            'task_id' => $task->id
        ]);

        return redirect()->back()
            ->with('success', '🎯 Task started successfully! Keep up the great work!');
    }

    /**
     * Complete a task from in_progress status.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function complete(string $id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);

        if (!$task->canBeCompleted()) {
            return redirect()->back()->with('error', 'Task cannot be completed. Status must be in_progress.');
        }

        $task->status = 'completed';
        $task->completed_time = now();
        $task->completed_at = now();
        
        // Calculate duration if start_time exists
        if ($task->start_time) {
            $duration = ceil($task->start_time->floatDiffInMinutes($task->completed_time));
            $task->duration_minutes = (int) $duration;
        }
        
        $task->save();

        // Create progress record
        $task->progressRecords()->create([
            'note' => 'Task selesai dikerjakan',
            'progress_value' => 100,
            'user_id' => Auth::id(),
            'task_id' => $task->id
        ]);

        // Update goal progress
        $this->updateGoalProgress($task->goal_id);

        $durationMessage = $task->duration_minutes ? " dengan durasi {$task->formatted_duration}" : "";
        
        return redirect()->back()
            ->with('success', "🎉 Excellent! You've successfully completed this task{$durationMessage}!");
    }

    /**
     * Force complete a task from pending status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceComplete(Request $request, string $id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);

        if (!$task->canBeForceCompleted()) {
            return redirect()->back()->with('error', 'Task cannot be completed directly. Status must be pending.');
        }

        $validator = Validator::make($request->all(), [
            'force_complete_reason' => 'required|string|min:10|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('show_force_complete_modal', true);
        }

        $task->status = 'completed';
        $task->completed_time = now();
        $task->completed_at = now();
        $task->force_complete_reason = $request->force_complete_reason;
        $task->duration_minutes = 0; // No duration for force complete
        $task->save();

        // Create progress record
        $task->progressRecords()->create([
            'note' => 'Task diselesaikan langsung: ' . $request->force_complete_reason,
            'progress_value' => 100,
            'user_id' => Auth::id(),
            'task_id' => $task->id
        ]);

        // Update goal progress
        $this->updateGoalProgress($task->goal_id);

        return redirect()->back()
            ->with('success', '✅ Task completed directly! Thank you for the explanation.');
    }
    
    /**
     * Update the progress of the associated goal.
     *
     * @param  string  $goalId
     * @return void
     */
    private function updateGoalProgress(string $goalId)
    {
        $goal = Goal::with('tasks')->findOrFail($goalId);
        $tasks = $goal->tasks;

        if ($tasks->isEmpty()) {
            $goal->progress_percent = 0;
            $goal->status = 'not_started';
            $goal->save();
            return;
        }

        $priorityWeights = [
            'low' => 15,
            'medium' => 50,
            'high' => 100,
        ];

        $totalValue = 0;
        $completedValue = 0;

        foreach ($tasks as $task) {
            // Default to 0 if priority is not in the map, though validation should prevent this.
            $weight = $priorityWeights[$task->priority] ?? 0;
            $totalValue += $weight;
            if ($task->status === 'completed') {
                $completedValue += $weight;
            }
        }

        $progressPercent = 0;
        // Avoid division by zero if all tasks have invalid/no priority
        if ($totalValue > 0) {
            $progressPercent = round(($completedValue / $totalValue) * 100);
        }

        $goal->progress_percent = $progressPercent;

        // Update status based on progress
        if ($progressPercent >= 100) {
            $goal->status = 'completed';
            $goal->progress_percent = 100; // Cap at 100
        } elseif ($progressPercent > 0) {
            $goal->status = 'in_progress';
        } else {
            $goal->status = 'not_started';
        }

        $goal->save();
    }
}
