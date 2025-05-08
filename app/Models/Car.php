<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'type',
        'license_plate',
        'fuel',
        'is_active',
        'remark',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
