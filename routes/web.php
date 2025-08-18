<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\LegalController;
use Illuminate\Support\Facades\Route;

// Welcome page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Legal Pages (Public - accessible to everyone)
Route::get('/terms', [LegalController::class, 'terms'])->name('legal.terms');
Route::get('/privacy', [LegalController::class, 'privacy'])->name('legal.privacy');
Route::get('/contact', [LegalController::class, 'contact'])->name('legal.contact');

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
    Route::post('/goals/{id}/finish', [GoalController::class, 'finish'])->name('goals.finish');
    
    // Tasks
    Route::resource('tasks', TaskController::class);
    Route::post('/tasks/{id}/complete', [TaskController::class, 'markAsCompleted'])->name('tasks.complete');
    Route::post('/tasks/{id}/start', [TaskController::class, 'start'])->name('tasks.start');
    Route::post('/tasks/{id}/finish', [TaskController::class, 'complete'])->name('tasks.finish');
    Route::post('/tasks/{id}/force-complete', [TaskController::class, 'forceComplete'])->name('tasks.force-complete');
    
    // Progress
    Route::resource('progress', ProgressController::class);
    
    // Achievements
    Route::resource('achievements', AchievementController::class)->only(['index', 'show']);
    Route::get('/achievements/{id}/download', [AchievementController::class, 'downloadCertificate'])->name('achievements.download');
    Route::post('/achievements/{id}/generate', [AchievementController::class, 'generateCertificate'])->name('achievements.generate');
    
    // Journals
    Route::get('/journals/calendar', [JournalController::class, 'calendar'])->name('journals.calendar');
    Route::get('/journals/insights', [JournalController::class, 'insights'])->name('journals.insights');
    Route::get('/journals/by-date/{date}', [JournalController::class, 'getByDate'])->name('journals.by-date');
    Route::resource('journals', JournalController::class);
    
    // Profile Settings
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    
                    // Help & Support
                Route::get('/help', [HelpController::class, 'index'])->name('help.index');
});
