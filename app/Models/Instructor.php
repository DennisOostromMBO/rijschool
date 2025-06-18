<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'number',
        'is_active',
        'remark',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get all lessons taught by this instructor
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
    
    /**
     * Get all students assigned to this instructor through lessons
     */
    public function students()
    {
        return $this->hasManyThrough(
            Student::class,
            Lesson::class,
            'instructor_id', // Foreign key on lessons table
            'id', // Foreign key on students table
            'id', // Local key on instructors table
            'registration_id' // Local key on lessons table (links to registration)
        )->distinct();
    }
}
