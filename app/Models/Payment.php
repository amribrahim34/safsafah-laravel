<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'payment_method',
        'payment_status',
        'transaction_id',
        'currency',
        'gateway_response',
        'amount',
        'proof_of_payment',
        'proof_uploaded_at',
        'verified_at',
        'rejection_reason',
    ];

    protected $casts = [
        'proof_uploaded_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
