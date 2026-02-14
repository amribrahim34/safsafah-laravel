<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkinConcern extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar',
        'name_en',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name_ar', 'like', "%{$search}%")
                  ->orWhere('name_en', 'like', "%{$search}%");
            });
        });
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_skin_concerns');
    }

    public function scopeHasProducts($query)
    {
        return $query->whereHas('products');
    }
}
