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
        'title',
        'target_group',
        'message',
        'notification_type',
        'date',
        'is_active',
        'is_sent',
        'sent_at',
        'remark',
        'recipient_id',
        'is_read',
        'read_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'is_active' => 'boolean',
        'is_sent' => 'boolean',
        'is_read' => 'boolean',
        'sent_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    /**
     * Get the user associated with the notification.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the recipient of the notification, if any.
     */
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
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
