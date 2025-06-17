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

    protected $casts = [
        'is_active' => 'boolean',
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

    /**
     * Call the stored procedure to create a payment.
     *
     * @param array $data
     * @return void
     */
    public static function createPaymentWithSP(array $data)
    {
        DB::statement('CALL CreatePayment(?, ?, ?, ?, ?)', [
            $data['invoice_id'],
            $data['date'],
            $data['status'],
            $data['remark'] ?? null,
            $data['is_active'] ?? 1,
        ]);
    }

    /**
     * Call the stored procedure to update a payment.
     *
     * @param int $id
     * @param array $data
     * @return void
     */
    public static function updatePaymentWithSP($id, array $data)
    {
        DB::statement('CALL UpdatePayment(?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $id,
            $data['invoice_id'],
            $data['date'],
            $data['status'],
            $data['is_active'] ?? 1,
            $data['remark'] ?? null,
            $data['reference_number'] ?? null,
        ]);
    }
}

