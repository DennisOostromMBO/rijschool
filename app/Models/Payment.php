<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_id',
        'date',
        'status',
        'is_active',
        'remark',
    ];

    /**
     * Get the invoice that this payment is for.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the student that this payment is from through the invoice and registration.
     */
    public function student()
    {
        return $this->invoice->student();
    }

    /**
     * Check if the payment is completed.
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }
}
