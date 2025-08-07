<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Journal extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'date',
        'title',
        'content',
        'mood',
        'tags',
        'category',
        'important',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'tags' => 'array',
        'important' => 'boolean',
    ];

    /**
     * Get the user that owns the journal.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get mood emoji.
     *
     * @return string
     */
    public function getMoodEmojiAttribute()
    {
        return match($this->mood) {
            'happy' => '😊',
            'sad' => '😢',
            'anxious' => '😰',
            'calm' => '😌',
            'angry' => '😠',
            'confused' => '😕',
            'excited' => '💪',
            'tired' => '😴',
            'satisfied' => '😌',
            'frustrated' => '😤',
            default => '😐',
        };
    }

    /**
     * Get mood badge class.
     *
     * @return string
     */
    public function getMoodBadgeClassAttribute()
    {
        return match($this->mood) {
            'happy' => 'bg-green-100 text-green-800',
            'sad' => 'bg-blue-100 text-blue-800',
            'anxious' => 'bg-yellow-100 text-yellow-800',
            'calm' => 'bg-indigo-100 text-indigo-800',
            'angry' => 'bg-red-100 text-red-800',
            'confused' => 'bg-gray-100 text-gray-800',
            'excited' => 'bg-orange-100 text-orange-800',
            'tired' => 'bg-purple-100 text-purple-800',
            'satisfied' => 'bg-teal-100 text-teal-800',
            'frustrated' => 'bg-pink-100 text-pink-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get category badge class.
     *
     * @return string
     */
    public function getCategoryBadgeClassAttribute()
    {
        return match($this->category) {
            'Personal' => 'bg-purple-100 text-purple-800',
            'Social' => 'bg-blue-100 text-blue-800',
            'Career' => 'bg-green-100 text-green-800',
            'Spiritual' => 'bg-indigo-100 text-indigo-800',
            'Academic' => 'bg-yellow-100 text-yellow-800',
            'Health' => 'bg-red-100 text-red-800',
            'Finance' => 'bg-emerald-100 text-emerald-800',
            'Hobby' => 'bg-pink-100 text-pink-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get formatted tags string.
     *
     * @return string
     */
    public function getFormattedTagsAttribute()
    {
        if (!$this->tags || empty($this->tags)) {
            return '';
        }

        return implode(' ', array_map(function($tag) {
            return '#' . $tag;
        }, $this->tags));
    }

    /**
     * Check if journal is for today.
     *
     * @return bool
     */
    public function getIsTodayAttribute()
    {
        return $this->date ? $this->date->isToday() : false;
    }

    /**
     * Get short content preview.
     *
     * @param int $length
     * @return string
     */
    public function getContentPreviewAttribute($length = 100)
    {
        return strlen($this->content) > $length 
            ? substr($this->content, 0, $length) . '...' 
            : $this->content;
    }

    /**
     * Get short content preview for calendar.
     *
     * @return string
     */
    public function getCalendarContentPreviewAttribute()
    {
        return Str::limit($this->content, 30);
    }
}
