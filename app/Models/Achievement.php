<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Achievement extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'goal_id',
        'title',
        'description',
        'certificate_message',
        'affirmation_message',
        'certificate_number',
        'achievement_date',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'achievement_date' => 'date',
    ];

    /**
     * Get the user that owns the achievement.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the goal that this achievement is for.
     */
    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    /**
     * Generate a unique certificate number.
     *
     * @return string
     */
    public static function generateCertificateNumber()
    {
        $prefix = 'CERT';
        $year = date('Y');
        $month = date('m');
        $random = strtoupper(substr(md5(uniqid()), 0, 6));
        
        return "{$prefix}-{$year}{$month}-{$random}";
    }

    /**
     * Get formatted achievement date.
     *
     * @return string
     */
    public function getFormattedDateAttribute()
    {
        return $this->achievement_date->format('F d, Y');
    }

    /**
     * Get achievement status badge class.
     *
     * @return string
     */
    public function getStatusBadgeClassAttribute()
    {
        return $this->status === 'active' 
            ? 'bg-green-100 text-green-800' 
            : 'bg-gray-100 text-gray-800';
    }
}
