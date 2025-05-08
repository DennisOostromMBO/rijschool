<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'lesson_count',
        'price_per_lesson',
        'is_active',
        'remark',
    ];

    protected $casts = [
        'lesson_count' => 'integer',
        'price_per_lesson' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}
