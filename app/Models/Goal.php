<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goal extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'priority',
        'status',
        'progress_percent',
        'category_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the user that owns the goal.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the goal.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // In your Goal model
    public function getFormattedStatusAttribute()
    {
        $statusMap = [
            'not_started' => 'Not Started',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            'complete' => 'Complete',
            'abandoned' => 'Abandoned',
        ];
        
        return $statusMap[$this->status] ?? $this->status;
    }

    /**
     * Get the tasks for the goal.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the progress records for the goal.
     */
    public function progressRecords()
    {
        return $this->hasMany(Progress::class);
    }

    /**
     * Calculate days remaining until the end date.
     *
     * @return int
     */
    public function getDaysRemainingAttribute()
    {
        $today = now()->startOfDay();
        $endDate = $this->end_date->startOfDay();
        
        if ($today > $endDate) {
            return 0;
        }
        
        return $today->diffInDays($endDate);
    }

    /**
     * Calculate if the goal is overdue.
     *
     * @return bool
     */
    public function getIsOverdueAttribute()
    {
        return now()->startOfDay() > $this->end_date->startOfDay() && $this->status !== 'completed';
    }
/**
     * Calculate the total duration of the goal in days.
     *
     * @return int|string
     */
    public function getDaysDurationAttribute()
    {
        if (!$this->end_date || !$this->start_date) {
            return 'N/A';
        }

        return $this->start_date->diffInDays($this->end_date);
    }
/**
     * Calculate the progress percentage based on completed tasks.
     *
     * @return int
     */
    public function getProgressPercentageAttribute()
    {
        $totalTasks = $this->tasks->count();
        if ($totalTasks === 0) {
            return 0;
        }

        $completedTasks = $this->tasks->where('is_completed', true)->count();

        return round(($completedTasks / $totalTasks) * 100);
    }
}