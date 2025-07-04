<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Task;
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
            ->get();
        
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
            ->where('status', '!=', 'completed')
            ->where('status', '!=', 'abandoned')
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

        $task = new Task($request->all());
        $task->user_id = Auth::id();
        $task->save();

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

        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        $data = $request->all();
        
        // Set completed_at timestamp if task is being marked as completed
        if ($request->status === 'completed' && $task->status !== 'completed') {
            $data['completed_at'] = now();
            
            // Create progress record
            $task->progressRecords()->create([
                'note' => 'Task marked as completed',
                'progress_value' => 100,
                'user_id' => Auth::id(),
                'task_id' => $task->id
            ]);
            
            // Update goal progress
            $this->updateGoalProgress($task->goal_id);
        } elseif ($request->status !== 'completed' && $task->status === 'completed') {
            // If task is being unmarked as completed
            $data['completed_at'] = null;
            
            // Update goal progress
            $this->updateGoalProgress($task->goal_id);
        }
        
        $task->update($data);

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
        $goalId = $task->goal_id;
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
        $task->status = 'completed';
        $task->updated_at = now();
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
     * Update the progress of the associated goal.
     *
     * @param  string  $goalId
     * @return void
     */
    private function updateGoalProgress(string $goalId)
    {
        $goal = Goal::findOrFail($goalId);
        $totalTasks = $goal->tasks()->count();
        
        if ($totalTasks > 0) {
            $completedTasks = $goal->tasks()->where('status', 'completed')->count();
            $progressPercent = round(($completedTasks / $totalTasks) * 100);
            
            $goal->progress_percent = $progressPercent;
            
            // Update status based on progress
            if ($progressPercent == 0) {
                $goal->status = 'not_started';
            } elseif ($progressPercent == 100) {
                $goal->status = 'completed';
            } else {
                $goal->status = 'in_progress';
            }
            
            $goal->save();
        }
    }
}
