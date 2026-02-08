<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'total',
        'subtotal',
        'tax',
        'shipping',
        'discount',
        'status',
        'promo_code_id',
        'address_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function promoCodes()
    {
        return $this->belongsToMany(PromoCode::class, 'order_promo_codes')
            ->withPivot('discount_amount')
            ->withTimestamps();
    }

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
             $q->where('id', 'like', "%{$search}%")
               ->orWhereHas('user', function($q) use ($search){
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('mobile', 'like', "%{$search}%");
               });
        });
    }
}
