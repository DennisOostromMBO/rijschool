<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'registration_id',
        'invoice_number',
        'invoice_date',
        'amount_excl_vat',
        'vat',
        'amount_incl_vat',
        'invoice_status',
        'is_active',
        'remark',
    ];

    /**
     * Get the registration that this invoice belongs to.
     */
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    /**
     * Get the student that this invoice is for through the registration.
     */
    public function student()
    {
        return $this->hasOneThrough(Student::class, Registration::class, 'id', 'id', 'registration_id', 'student_id');
    }

    /**
     * Get the payments for this invoice.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Check if the invoice is paid.
     */
    public function isPaid()
    {
        return $this->invoice_status === 'paid';
    }

    /**
     * Calculate the total amount paid for this invoice.
     */
    public function totalPaid()
    {
        return $this->payments()->where('status', 'completed')->sum('amount');
    }

    /**
     * Calculate the remaining amount to be paid.
     */
    public function remainingAmount()
    {
        return $this->amount_incl_vat - $this->totalPaid();
    }
}
