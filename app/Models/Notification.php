<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'target_group',
        'message',
        'notification_type',
        'date',
        'is_active',
        'remark',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user associated with the notification.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the notification is for students.
     */
    public function isForStudents()
    {
        return $this->target_group === 'Student' || $this->target_group === 'Both';
    }

    /**
     * Check if the notification is for instructors.
     */
    public function isForInstructors()
    {
        return $this->target_group === 'Instructor' || $this->target_group === 'Both';
    }
}
