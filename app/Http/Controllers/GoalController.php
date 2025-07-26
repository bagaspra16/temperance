<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Goal;
use App\Models\Task;
use App\Models\Progress;
use App\Models\Achievement;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $goals = Goal::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        
        $categories = Category::where('user_id', Auth::id())->get();

        return view('goals.index', compact('goals', 'categories'));
    }

    /**
     * Display a full monthly calendar view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function calendar(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        
        $currentDate = Carbon::create($year, $month, 1);
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();
        
        // Get the first day of the week (Sunday = 0, Monday = 1)
        $firstDayOfWeek = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
        $lastDayOfWeek = $endOfMonth->copy()->endOfWeek(Carbon::SATURDAY);
        
        // Generate calendar days
        $calendarDays = [];
        $currentDay = $firstDayOfWeek->copy();
        
        while ($currentDay <= $lastDayOfWeek) {
            $calendarDays[] = [
                'date' => $currentDay->copy(),
                'isCurrentMonth' => $currentDay->month === $month,
                'isToday' => $currentDay->isToday(),
                'isWeekend' => $currentDay->isWeekend(),
            ];
            $currentDay->addDay();
        }
        
        // Get goals and tasks for the month
        $goals = Goal::where('user_id', Auth::id())
            ->where(function($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                      ->orWhereBetween('end_date', [$startOfMonth, $endOfMonth])
                      ->orWhere(function($q) use ($startOfMonth, $endOfMonth) {
                          $q->where('start_date', '<=', $startOfMonth)
                            ->where('end_date', '>=', $endOfMonth);
                      });
            })
            ->with(['category', 'tasks'])
            ->get();
            
        $tasks = Task::where('user_id', Auth::id())
            ->whereNotNull('due_date')
            ->whereBetween('due_date', [$startOfMonth, $endOfMonth])
            ->with(['goal.category'])
            ->get();
        
        // Organize events by date
        $eventsByDate = [];
        
        foreach ($goals as $goal) {
            $startDate = Carbon::parse($goal->start_date);
            $endDate = Carbon::parse($goal->end_date);
            
            $current = $startDate->copy();
            while ($current <= $endDate) {
                $dateKey = $current->format('Y-m-d');
                if (!isset($eventsByDate[$dateKey])) {
                    $eventsByDate[$dateKey] = [];
                }
                
                $eventsByDate[$dateKey][] = [
                    'type' => 'goal',
                    'title' => $goal->title,
                    'goal' => $goal,
                    'color' => $goal->category->color ?? '#6B7280',
                    'status' => $goal->status,
                    'priority' => $goal->priority,
                ];
                
                $current->addDay();
            }
        }
        
        foreach ($tasks as $task) {
            $dateKey = $task->due_date->format('Y-m-d');
            if (!isset($eventsByDate[$dateKey])) {
                $eventsByDate[$dateKey] = [];
            }
            
            $eventsByDate[$dateKey][] = [
                'type' => 'task',
                'title' => $task->title,
                'task' => $task,
                'color' => $task->goal->category->color ?? '#6B7280',
                'status' => $task->status,
                'priority' => $task->priority,
            ];
        }
        
        // Previous and next month navigation
        $previousMonth = $currentDate->copy()->subMonth();
        $nextMonth = $currentDate->copy()->addMonth();
        
        // Get categories for filter
        $categories = Category::where('user_id', Auth::id())->get();
        
        // Get recent tasks for activity feed
        $recentTasks = Task::where('user_id', Auth::id())
            ->with(['goal.category'])
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
        
        return view('goals.calendar', compact(
            'calendarDays',
            'eventsByDate',
            'currentDate',
            'previousMonth',
            'nextMonth',
            'goals',
            'tasks',
            'categories',
            'recentTasks'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::where('user_id', Auth::id())->get();
        return view('goals.create', compact('categories'));
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
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'priority' => 'required|in:low,medium,high',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $goal = new Goal($request->all());
        $goal->user_id = Auth::id();
        $goal->progress_percent = 0; // Menggunakan progress_percent
        $goal->save();

        return redirect()->route('goals.show', $goal->id)
            ->with('success', 'Goal created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function show(string $id)
    {
        $goal = Goal::with(['tasks', 'progressRecords', 'tasks.progressRecords'])->where('user_id', Auth::id())->findOrFail($id);

        $goalProgress = $goal->progressRecords;
        $taskProgress = $goal->tasks->flatMap(function ($task) {
            return $task->progressRecords;
        });

        $progressHistory = $goalProgress->merge($taskProgress)->sortByDesc('created_at');

        return view('goals.show', compact('goal', 'progressHistory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        $goal = Goal::where('user_id', Auth::id())->findOrFail($id);
        
        // Prevent editing finished goals
        if ($goal->isFinished()) {
            return redirect()->route('goals.show', $goal->id)
                ->with('error', '⚠️ Finished goals cannot be edited. You can only delete them.');
        }
        
        $categories = Category::where('user_id', Auth::id())->get();
        
        return view('goals.edit', compact('goal', 'categories'));
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
        $goal = Goal::where('user_id', Auth::id())->findOrFail($id);
        
        // Prevent updating finished goals
        if ($goal->isFinished()) {
            return redirect()->route('goals.show', $goal->id)
                ->with('error', '⚠️ Finished goals cannot be updated. You can only delete them.');
        }
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:not_started,in_progress,complete,finished,abandoned',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $goal->update($request->all());

        // If status is complete, set progress to 100%
        if ($request->status === 'complete' && $goal->progress_percent < 100) {
            $goal->progress_percent = 100;
            $goal->save();
        }

        // If status is finished, ensure progress is 100%
        if ($request->status === 'finished' && $goal->progress_percent < 100) {
            $goal->progress_percent = 100;
            $goal->save();
        }

        return redirect()->route('goals.show', $goal->id)
            ->with('success', 'Goal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        $goal = Goal::where('user_id', Auth::id())->findOrFail($id);

        $tasks = Task::where('goal_id', $goal->id)->get();

        $progress = Progress::whereIn('task_id', $tasks->pluck('id'))->get();

        $achievements = Achievement::where('goal_id', $goal->id)->get();

        foreach ($progress as $p) {
            $p->delete();
        }
        foreach ($tasks as $t) {
            $t->delete();
        }
        foreach ($achievements as $a) {
            $a->delete();
        }
        
        $goal->delete();

        return redirect()->route('goals.index')
            ->with('success', 'Goal deleted successfully.');
    }

    /**
     * Mark goal as finished.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function finish(string $id)
    {
        $goal = Goal::with('user')->where('user_id', Auth::id())->findOrFail($id);
        
        // Check if goal is completed (100% progress)
        if ($goal->progress_percent < 100) {
            return redirect()->route('goals.show', $goal->id)
                ->with('error', '⚠️ Goal must be 100% completed before it can be marked as finished. Current progress: ' . $goal->progress_percent . '%');
        }
        
        // Update status to finished
        $goal->status = 'finished';
        $goal->save();

        // Create achievement certificate with user name
        $this->createAchievementCertificate($goal);
        
        return redirect()->route('goals.show', $goal->id)
            ->with('success', '🎉 Congratulations! Goal "' . $goal->title . '" has been marked as finished. A special achievement certificate has been created for you!');
    }

    /**
     * Create achievement certificate for finished goal.
     *
     * @param Goal $goal
     * @return void
     */
    private function createAchievementCertificate($goal)
    {
        try {
            // Get user name from the goal's user relationship
            $userName = $goal->user->name ?? 'Achiever';
            
            // Generate AI messages with user name
            $certificateMessage = AIService::generateCertificateMessage($goal->title, $userName);
            $affirmationMessage = AIService::generateAffirmationMessage($goal->title, $userName);

            // Create achievement record
            Achievement::create([
                'user_id' => $goal->user_id,
                'goal_id' => $goal->id,
                'title' => 'Goal Completion: ' . $goal->title,
                'description' => 'Successfully completed the goal "' . $goal->title . '" with 100% progress.',
                'certificate_message' => $certificateMessage,
                'affirmation_message' => $affirmationMessage,
                'certificate_number' => Achievement::generateCertificateNumber(),
                'achievement_date' => now(),
                'status' => 'active',
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to create achievement certificate: ' . $e->getMessage());
        }
    }
    
    /**
     * Get tasks and goals for a specific date.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDateDetails(Request $request)
    {
        $date = $request->get('date');
        
        if (!$date) {
            return response()->json(['error' => 'Date parameter is required'], 400);
        }
        
        try {
            $targetDate = Carbon::parse($date);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid date format'], 400);
        }
        
        // Get tasks for this date
        $tasks = Task::where('user_id', Auth::id())
            ->whereNotNull('due_date')
            ->whereDate('due_date', $targetDate)
            ->with(['goal'])
            ->get()
            ->map(function ($task) {
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'status' => $task->status,
                    'priority' => $task->priority,
                    'goal_title' => $task->goal ? $task->goal->title : null,
                ];
            });
        
        // Get goals active on this date
        $goals = Goal::where('user_id', Auth::id())
            ->where(function($query) use ($targetDate) {
                $query->where('start_date', '<=', $targetDate)
                      ->where('end_date', '>=', $targetDate);
            })
            ->get()
            ->map(function ($goal) {
                return [
                    'id' => $goal->id,
                    'title' => $goal->title,
                    'status' => $goal->status,
                    'priority' => $goal->priority,
                    'progress_percent' => $goal->progress_percent,
                ];
            });
        
        return response()->json([
            'tasks' => $tasks,
            'goals' => $goals,
        ]);
    }

    /**
     * Update the progress of a goal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProgress(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'progress_percent' => 'required|integer|min:0|max:100',
            'status' => 'required|string|in:not_started,in_progress,complete,completed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $goal = Goal::where('user_id', Auth::id())->findOrFail($id);
        
        // Update goal progress
        $goal->progress_percent = $request->progress_percent;
        $goal->status = $request->status;
        
        // Create progress record
        $goal->progressRecords()->create([
            'note' => 'Goal progress updated to ' . $request->progress_percent . '%',
            'progress_value' => $request->progress_percent,
            'user_id' => Auth::id(),
            'goal_id' => $goal->id
        ]);
        
        // Ensure status is consistent with progress
        if ($request->progress_percent == 0 && $request->status != 'not_started') {
            $goal->status = 'not_started';
        } elseif ($request->progress_percent == 100 && $request->status != 'complete' && $request->status != 'completed') {
            $goal->status = 'complete';
        } elseif ($request->progress_percent > 0 && $request->progress_percent < 100 && $request->status != 'in_progress') {
            $goal->status = 'in_progress';
        }
        
        $goal->save();

        return redirect()->route('goals.show', $goal->id)
            ->with('success', 'Goal progress updated successfully.');
    }
}