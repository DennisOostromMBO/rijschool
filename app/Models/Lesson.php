<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'instructor_id',
        'car_id',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'lesson_status',
        'goal',
        'student_comment',
        'instructor_comment',
        'is_active',
        'remark',
    ];

    protected $casts = [
        'start_date' => 'date',
        'start_time' => 'time',
        'end_date' => 'date',
        'end_time' => 'time',
        'is_active' => 'boolean',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function student()
    {
        return $this->hasOneThrough(Student::class, Registration::class, 'id', 'id', 'registration_id', 'student_id');
    }

    public function pickupAddress()
    {
        return $this->hasOne(PickupAddressPerLesson::class);
    }

    public function isToday()
    {
        return $this->start_date == date('Y-m-d');
    }

    public function isCompleted()
    {
        return $this->lesson_status === 'completed';
    }
}
