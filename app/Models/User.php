<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the roles associated with the user.
     */
    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    /**
     * Get the contact information for the user.
     */
    public function contact()
    {
        return $this->hasOne(Contact::class);
    }

    /**
     * Get the student profile if this user is a student.
     */
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    /**
     * Get the instructor profile if this user is an instructor.
     */
    public function instructor()
    {
        return $this->hasOne(Instructor::class);
    }

    /**
     * Get notifications created by this user.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
