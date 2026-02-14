<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar',
        'name_en',
        'logo',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name_ar', 'like', "%{$search}%")
                  ->orWhere('name_en', 'like', "%{$search}%");
            });
        });
    }

    public function getLogoUrlAttribute()
    {
        if (isset($this->logo)) {
           $img = $this->logo;
            return asset('storage/' . $img);
        }
    }

    public function scopeHasProducts($query)
    {
        return $query->whereHas('products');
    }

    
}
