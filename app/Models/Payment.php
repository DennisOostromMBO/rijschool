<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
     * Get the user (payer) through the related models.
     */
    public function user()
    {
        return $this->invoice->registration->student->user ?? null;
    }

    /**
     * Get payments using the stored procedure.
     */
    public static function getPaymentsFromSP()
    {
        return DB::select('CALL GetPayments()');
    }
}
