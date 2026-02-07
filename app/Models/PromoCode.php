<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $fillable = [
        'code',
        'discount',
        'expiry_date',
        'usage_limit',
        'times_used',
        'active',
        'is_percent',
        'min_order_value',
        'max_discount_amount',
    ];

    protected $casts = [
        'expiry_date' => 'datetime',
        'active' => 'boolean',
        'is_percent' => 'boolean',
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function ordersViaPivot()
    {
        return $this->belongsToMany(Order::class, 'order_promo_codes')
            ->withPivot('discount_amount')
            ->withTimestamps();
    }
}
