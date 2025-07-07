<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Progress;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $progress = Progress::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('progress.index', compact('progress'));
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
            
        $tasks = Task::where('user_id', Auth::id())
            ->where('status', '!=', 'completed')
            ->get();
        
        return view('progress.create', compact('goals', 'tasks'));
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
            'note' => 'required|string',
            'progress_value' => 'required|integer|min:0|max:100',
            'goal_id' => 'nullable|exists:goals,id',
            'task_id' => 'nullable|exists:tasks,id',
            'record_type' => 'required|in:goal,task',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Ensure at least one of goal_id or task_id is provided based on record_type
        if ($request->record_type == 'goal' && empty($request->goal_id)) {
            return redirect()->back()
                ->withErrors(['error' => 'A goal must be selected for goal progress records.'])
                ->withInput();
        } elseif ($request->record_type == 'task' && empty($request->task_id)) {
            return redirect()->back()
                ->withErrors(['error' => 'A task must be selected for task progress records.'])
                ->withInput();
        }

        $progress = new Progress();
        $progress->note = $request->note;
        $progress->user_id = Auth::id();
        
        if ($request->record_type == 'goal') {
            $progress->goal_id = $request->goal_id;
            $progress->progress_value = $request->progress_value;
        } elseif ($request->record_type == 'task') {
            $progress->task_id = $request->task_id;
            $progress->progress_value = $request->completed ? 100 : 0;
        }
        
        $progress->save();
        
        // Handle goal progress update
        if ($request->record_type == 'goal') {
            $goal = Goal::findOrFail($request->goal_id);
            $goal->progress_percent = $request->progress_value;
            
            // Update status based on progress
            if ($request->status) {
                $goal->status = $request->status;
            } else {
                if ($request->progress_value == 0) {
                    $goal->status = 'not_started';
                } elseif ($request->progress_value == 100) {
                    $goal->status = 'completed';
                } else {
                    $goal->status = 'in_progress';
                }
            }
            
            $goal->save();
            
            return redirect()->route('goals.show', $goal->id)
                ->with('success', 'Progress recorded successfully.');
        }
        
        // Handle task status update
        if ($request->record_type == 'task') {
            $task = Task::findOrFail($request->task_id);
            
            // Update task status based on completed checkbox
            if (isset($request->completed)) {
                $task->status = $request->completed ? 'completed' : 'pending';
                $task->completed_at = $request->completed ? now() : null;
                $task->save();
                
                // Update associated goal progress
                if ($task->goal_id) {
                    $this->updateGoalProgress($task->goal_id);
                }
            }
            
            return redirect()->route('tasks.show', $task->id)
                ->with('success', 'Progress recorded successfully.');
        }
        
        return redirect()->route('progress.index')
            ->with('success', 'Progress recorded successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function show(string $id)
    {
        $progress = Progress::where('user_id', Auth::id())->findOrFail($id);
        
        return view('progress.show', compact('progress'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        $progress = Progress::where('user_id', Auth::id())->findOrFail($id);
        $goals = Goal::where('user_id', Auth::id())
            ->where('status', '!=', 'completed')
            ->where('status', '!=', 'abandoned')
            ->get();
            
        $tasks = Task::where('user_id', Auth::id())
            ->where('status', '!=', 'completed')
            ->get();
        
        return view('progress.edit', compact('progress', 'goals', 'tasks'));
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
            'note' => 'required|string',
            'progress_value' => 'nullable|integer|min:0|max:100',
            'goal_id' => 'nullable|exists:goals,id',
            'task_id' => 'nullable|exists:tasks,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $progress = Progress::where('user_id', Auth::id())->findOrFail($id);
        $progress->note = $request->note;
        
        // Handle goal progress update
        if ($progress->goal_id) {
            if (isset($request->progress_value)) {
                $progress->progress_value = $request->progress_value;
            }
            $progress->save();
            
            // Update the associated goal's progress
            $goal = Goal::findOrFail($progress->goal_id);
            $goal->progress_percent = $request->progress_value;
            
            // Update status based on progress
            if ($request->status) {
                $goal->status = $request->status;
            } else {
                if ($request->progress_value == 0) {
                    $goal->status = 'not_started';
                } elseif ($request->progress_value == 100) {
                    $goal->status = 'completed';
                } else {
                    $goal->status = 'in_progress';
                }
            }
            
            $goal->save();
        }
        
        // Handle task status update
        if ($progress->task_id) {
            $task = Task::findOrFail($progress->task_id);
            
            // Update task status based on completed checkbox
            if (isset($request->completed)) {
                $task->status = $request->completed ? 'completed' : 'pending';
                $task->completed_at = $request->completed ? now() : null;
                $progress->progress_value = $request->completed ? 100 : 0;
            }
            
            $task->save();
            $progress->save();
            
            // Update associated goal progress
            if ($task->goal_id) {
                $this->updateGoalProgress($task->goal_id);
            }
        }
        
        // Redirect based on the updated record
        if ($progress->goal_id) {
            return redirect()->route('goals.show', $progress->goal_id)
                ->with('success', 'Progress updated successfully.');
        }
        
        if ($progress->task_id) {
            return redirect()->route('tasks.show', $progress->task_id)
                ->with('success', 'Progress updated successfully.');
        }
        
        return redirect()->route('progress.index')
            ->with('success', 'Progress updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        $progress = Progress::where('user_id', Auth::id())->findOrFail($id);
        $goalId = $progress->goal_id;
        $taskId = $progress->task_id;
        $progress->delete();

        if ($goalId) {
            return redirect()->route('goals.show', $goalId)
                ->with('success', 'Progress record deleted successfully.');
        } elseif ($taskId) {
            return redirect()->route('tasks.show', $taskId)
                ->with('success', 'Progress record deleted successfully.');
        } else {
            return redirect()->route('progress.index')
                ->with('success', 'Progress record deleted successfully.');
        }
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
            // Default to 0 if priority is not in the map
            $weight = $priorityWeights[$task->priority] ?? 0;
            $totalValue += $weight;
            if ($task->status === 'completed') {
                $completedValue += $weight;
            }
        }

        $progressPercent = 0;
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
