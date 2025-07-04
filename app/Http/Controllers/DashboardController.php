<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Goal;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
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
        
        return view('dashboard', compact(
            'totalGoals',
            'completedGoals',
            'totalTasks',
            'completedTasks',
            'categories',
            'upcomingGoals',
            'recentTasks'
        ));
    }
}
