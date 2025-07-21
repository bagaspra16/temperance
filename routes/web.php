<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Authentication routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/calendar/details', [DashboardController::class, 'getDateDetails'])->name('dashboard.calendar.details');
    Route::get('/dashboard/weekly-time-stats', [DashboardController::class, 'getWeeklyTimeStats'])->name('dashboard.weekly-time-stats');
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Goals
    Route::get('/goals/calendar', [GoalController::class, 'calendar'])->name('goals.calendar');
    Route::get('/goals/calendar/details', [GoalController::class, 'getDateDetails'])->name('goals.calendar.details');
    Route::resource('goals', GoalController::class);
    Route::patch('/goals/{id}/progress', [GoalController::class, 'updateProgress'])->name('goals.progress');
    
    // Tasks
    Route::resource('tasks', TaskController::class);
    Route::post('/tasks/{id}/complete', [TaskController::class, 'markAsCompleted'])->name('tasks.complete');
    Route::post('/tasks/{id}/start', [TaskController::class, 'start'])->name('tasks.start');
    Route::post('/tasks/{id}/finish', [TaskController::class, 'complete'])->name('tasks.finish');
    Route::post('/tasks/{id}/force-complete', [TaskController::class, 'forceComplete'])->name('tasks.force-complete');
    
    // Progress
    Route::resource('progress', ProgressController::class);
});
