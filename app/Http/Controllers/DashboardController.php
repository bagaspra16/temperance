<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Goal;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        $currentDate = \Carbon\Carbon::create($year, $month, 1);
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();
        
        $totalGoals = Goal::where('user_id', $user->id)->count();
        $completedGoals = Goal::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();
        
        $totalTasks = Task::where('user_id', $user->id)->count();
        $completedTasks = Task::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();
        
        $categories = Category::where('user_id', $user->id)->get();
        
        $upcomingGoals = Goal::where('user_id', $user->id)
            ->where('status', '!=', 'completed')
            ->orderBy('end_date', 'asc')
            ->take(5)
            ->get();
        
        $recentTasks = Task::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Calendar data
        $currentDate = Carbon::now();
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
                'isCurrentMonth' => $currentDay->month === $currentDate->month,
                'isToday' => $currentDay->isToday(),
                'isWeekend' => $currentDay->isWeekend(),
            ];
            $currentDay->addDay();
        }
        
        // Get goals and tasks for the month
        $goals = Goal::where('user_id', $user->id)
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
            
        $tasks = Task::where('user_id', $user->id)
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
        
        return view('dashboard', compact(
            'totalGoals',
            'completedGoals',
            'totalTasks',
            'completedTasks',
            'categories',
            'upcomingGoals',
            'recentTasks',
            'calendarDays',
            'eventsByDate',
            'currentDate',
            'previousMonth',
            'nextMonth',
            'goals',
            'tasks'
        ));
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
}
