<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupAddress extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'street_name',
        'house_number',
        'addition',
        'postal_code',
        'city',
        'is_active',
        'remark',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the lessons that use this pickup address.
     */
    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, PickupAddressPerLesson::class, 'pickup_address_id', 'id', 'id', 'lesson_id');
    }

    /**
     * Get the pickup address assignments.
     */
    public function pickupAddressPerLessons()
    {
        return $this->hasMany(PickupAddressPerLesson::class);
    }

    /**
     * Get the full address as a formatted string.
     *
     * @return string
     */
    public function getFullAddressAttribute()
    {
        $address = $this->street_name . ' ' . $this->house_number;

        if ($this->addition) {
            $address .= ' ' . $this->addition;
        }

        return $address . ', ' . $this->postal_code . ' ' . $this->city;
    }
}
