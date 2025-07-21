<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
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
        'due_date',
        'priority',
        'status',
        'goal_id',
        'user_id',
        'completed_at',
        'start_time',
        'completed_time',
        'duration_minutes',
        'force_complete_reason',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
        'start_time' => 'datetime',
        'completed_time' => 'datetime',
    ];

    /**
     * Get the user that owns the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the goal that owns the task.
     */
    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    /**
     * Get the progress records for the task.
     */
    public function progressRecords()
    {
        return $this->hasMany(Progress::class);
    }

    /**
     * Calculate if the task is overdue.
     *
     * @return bool
     */
    public function getIsOverdueAttribute()
    {
        if (!$this->due_date) {
            return false;
        }
        
        return now()->startOfDay() > $this->due_date->startOfDay() && $this->status !== 'completed';
    }
    
    /**
     * Check if the task is completed.
     *
     * @return bool
     */
    public function getIsCompletedAttribute()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if the task can be started.
     *
     * @return bool
     */
    public function canBeStarted()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the task can be completed normally.
     *
     * @return bool
     */
    public function canBeCompleted()
    {
        return $this->status === 'in_progress';
    }

    /**
     * Check if the task can be force completed.
     *
     * @return bool
     */
    public function canBeForceCompleted()
    {
        return $this->status === 'pending';
    }

    /**
     * Get formatted duration string.
     *
     * @return string
     */
    public function getFormattedDurationAttribute()
    {
        if (!$this->duration_minutes) {
            return 'No duration';
        }

        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;

        if ($hours > 0) {
            $hourText = $hours . ' hour' . ($hours > 1 ? 's' : '');
            $minuteText = $minutes > 0 ? $minutes . ' minute' . ($minutes > 1 ? 's' : '') : '';
            return trim($hourText . ' ' . $minuteText);
        }

        return $minutes . ' minute' . ($minutes > 1 ? 's' : '');
    }

    /**
     * Get status badge class.
     *
     * @return string
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'in_progress' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}