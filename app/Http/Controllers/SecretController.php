<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Goal;
use App\Models\Task;
use App\Models\Journal;
use App\Models\Progress;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SecretController extends Controller
{
    /**
     * Check if user has access to secret pages
     */
    private function checkSecretAccess()
    {
        if (!Auth::check() || Auth::user()->email !== 'protagonist@temperance.com') {
            abort(403, 'Access denied. You do not have permission to access this page.');
        }
    }

    /**
     * Display the secret admin dashboard.
     */
    public function index()
    {
        $this->checkSecretAccess();
        // Get analytics data
        $analytics = $this->getAnalyticsData();
        
        // Get user statistics
        $userStats = $this->getUserStatistics();
        
        // Get activity distribution
        $activityDistribution = $this->getActivityDistribution();
        
        // Get recent users
        $recentUsers = User::with(['categories', 'goals', 'tasks', 'journals'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('secret.dashboard', compact(
            'analytics',
            'userStats', 
            'activityDistribution',
            'recentUsers'
        ));
    }

    /**
     * Display user management page with search functionality.
     */
    public function users(Request $request)
    {
        $this->checkSecretAccess();
        $query = User::with(['categories', 'goals', 'tasks', 'journals']);
        
        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        
        if (in_array($sortBy, ['name', 'email', 'created_at'])) {
            $query->orderBy($sortBy, $sortDirection);
        }

        $users = $query->paginate(20)->withQueryString();

        return view('secret.users', compact('users'));
    }

    /**
     * Display detailed user information.
     */
    public function userDetail($id)
    {
        $this->checkSecretAccess();
        $user = User::with([
            'categories.goals.tasks',
            'goals.tasks',
            'tasks.goal',
            'journals',
            'progressRecords',
            'achievements'
        ])->findOrFail($id);

        // Get user statistics
        $userStats = [
            'total_categories' => $user->categories->count(),
            'total_goals' => $user->goals->count(),
            'completed_goals' => $user->goals->where('status', 'completed')->count(),
            'total_tasks' => $user->tasks->count(),
            'completed_tasks' => $user->tasks->where('status', 'completed')->count(),
            'total_journals' => $user->journals->count(),
            'total_achievements' => $user->achievements->count(),
        ];

        // Get recent activity
        $recentActivity = $this->getUserRecentActivity($user);

        return view('secret.user-detail', compact('user', 'userStats', 'recentActivity'));
    }

    /**
     * Get analytics data for charts.
     */
    private function getAnalyticsData()
    {
        // Total users
        $totalUsers = User::count();
        
        // Active users (users with activity in last 30 days)
        $activeUsers = User::whereHas('tasks', function($query) {
            $query->where('updated_at', '>=', Carbon::now()->subDays(30));
        })->orWhereHas('goals', function($query) {
            $query->where('updated_at', '>=', Carbon::now()->subDays(30));
        })->orWhereHas('journals', function($query) {
            $query->where('updated_at', '>=', Carbon::now()->subDays(30));
        })->distinct()->count();

        // User growth over time (last 12 months)
        $userGrowth = User::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', Carbon::now()->subMonths(12))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // Activity distribution
        $activityDistribution = [
            'categories' => Category::count(),
            'goals' => Goal::count(),
            'completed_goals' => Goal::where('status', 'completed')->count(),
            'tasks' => Task::count(),
            'completed_tasks' => Task::where('status', 'completed')->count(),
            'journals' => Journal::count(),
            'achievements' => Achievement::count(),
        ];

        // Most active users (by total activities)
        $mostActiveUsers = User::withCount(['goals', 'tasks', 'journals', 'categories'])
            ->get()
            ->map(function($user) {
                $user->total_activities = $user->goals_count + $user->tasks_count + $user->journals_count + $user->categories_count;
                return $user;
            })
            ->sortByDesc('total_activities')
            ->take(5);

        // Goals completion rate over time (last 6 months)
        $goalsCompletion = Goal::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed')
        )
        ->where('created_at', '>=', Carbon::now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // Tasks completion rate over time (last 6 months)
        $tasksCompletion = Task::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed')
        )
        ->where('created_at', '>=', Carbon::now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // User activity by day of week
        $activityByDay = User::select(
            DB::raw('DAYNAME(created_at) as day_name'),
            DB::raw('DAYOFWEEK(created_at) as day_order'),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('day_name', 'day_order')
        ->orderBy('day_order')
        ->get();

        // Priority distribution for tasks
        $taskPriorityDistribution = Task::select('priority', DB::raw('COUNT(*) as count'))
            ->groupBy('priority')
            ->get();

        // Goal status distribution
        $goalStatusDistribution = Goal::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // Journal mood distribution (if mood field exists)
        $journalMoodDistribution = Journal::select('mood', DB::raw('COUNT(*) as count'))
            ->whereNotNull('mood')
            ->groupBy('mood')
            ->get();

        // Handle empty data gracefully
        if ($goalsCompletion->isEmpty()) {
            $goalsCompletion = collect();
        }

        if ($tasksCompletion->isEmpty()) {
            $tasksCompletion = collect();
        }

        if ($activityByDay->isEmpty()) {
            $activityByDay = collect();
        }

        return [
            'total_users' => $totalUsers,
            'active_users' => $activeUsers,
            'inactive_users' => $totalUsers - $activeUsers,
            'user_growth' => $userGrowth,
            'activity_distribution' => $activityDistribution,
            'most_active_users' => $mostActiveUsers,
            'goals_completion' => $goalsCompletion,
            'tasks_completion' => $tasksCompletion,
            'activity_by_day' => $activityByDay,
            'task_priority_distribution' => $taskPriorityDistribution,
            'goal_status_distribution' => $goalStatusDistribution,
            'journal_mood_distribution' => $journalMoodDistribution,
        ];
    }

    /**
     * Get user statistics.
     */
    private function getUserStatistics()
    {
        return [
            'total_users' => User::count(),
            'users_this_month' => User::whereMonth('created_at', Carbon::now()->month)->count(),
            'users_this_week' => User::where('created_at', '>=', Carbon::now()->startOfWeek())->count(),
            'users_today' => User::whereDate('created_at', Carbon::today())->count(),
        ];
    }

    /**
     * Get activity distribution data.
     */
    private function getActivityDistribution()
    {
        return [
            'categories' => Category::count(),
            'goals' => Goal::count(),
            'completed_goals' => Goal::where('status', 'completed')->count(),
            'tasks' => Task::count(),
            'completed_tasks' => Task::where('status', 'completed')->count(),
            'journals' => Journal::count(),
            'achievements' => Achievement::count(),
        ];
    }

    /**
     * Get recent activity for a specific user.
     */
    private function getUserRecentActivity($user)
    {
        $activities = collect();

        // Recent goals
        $user->goals->each(function($goal) use ($activities) {
            $activities->push([
                'type' => 'goal',
                'title' => $goal->title,
                'status' => $goal->status,
                'created_at' => $goal->created_at,
                'updated_at' => $goal->updated_at,
            ]);
        });

        // Recent tasks
        $user->tasks->each(function($task) use ($activities) {
            $activities->push([
                'type' => 'task',
                'title' => $task->title,
                'status' => $task->status,
                'created_at' => $task->created_at,
                'updated_at' => $task->updated_at,
            ]);
        });

        // Recent journals
        $user->journals->each(function($journal) use ($activities) {
            $activities->push([
                'type' => 'journal',
                'title' => $journal->title,
                'status' => 'created',
                'created_at' => $journal->created_at,
                'updated_at' => $journal->updated_at,
            ]);
        });

        return $activities->sortByDesc('updated_at')->take(20);
    }
}
