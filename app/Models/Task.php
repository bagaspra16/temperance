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
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
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
    public function getCompletedAttribute()
    {
        return $this->status === 'completed';
    }
}