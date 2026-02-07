<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'category_id',
        'brand_id',
        'price',
        'image',
        'sku',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function activeIngredients()
    {
        return $this->belongsToMany(ActiveIngredient::class, 'product_active_ingredients');
    }

    public function skinTypes()
    {
        return $this->belongsToMany(SkinType::class, 'product_skin_types');
    }

    public function skinConcerns()
    {
        return $this->belongsToMany(SkinConcern::class, 'product_skin_concerns');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishLists()
    {
        return $this->hasMany(WishList::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name_ar', 'like', "%{$search}%")
                  ->orWhere('name_en', 'like', "%{$search}%")
                  ->orWhere('description_ar', 'like', "%{$search}%")
                  ->orWhere('description_en', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        });
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
