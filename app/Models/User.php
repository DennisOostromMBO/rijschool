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
        'first_name',
        'middle_name',
        'last_name',
        'birth_date',
        'username',
        'email',
        'phone',
        'password',
        // Removing role_id from fillable to prevent direct assignment
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
        return $this->belongsToMany(Role::class);
    }

    /**
     * Check if the user has a specific role.
     * 
     * @param string|array $roles
     * @return bool
     */
    public function hasRole($roles): bool
    {
        if (is_string($roles)) {
            return $this->roles->where('name', $roles)->isNotEmpty();
        }
        
        return $this->roles->whereIn('name', $roles)->isNotEmpty();
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('Admin');
    }

    /**
     * Check if the user is an instructor.
     * 
     * @return bool
     */
    public function isInstructor(): bool
    {
        return $this->hasRole('Instructor');
    }

    /**
     * Check if the user is a student.
     * 
     * @return bool
     */
    public function isStudent(): bool
    {
        return $this->hasRole('Student');
    }

    /**
     * Get all users with a specific role.
     * 
     * @param string $role
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function withRole(string $role)
    {
        return static::whereHas('roles', function($query) use ($role) {
            $query->where('name', $role);
        })->get();
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
