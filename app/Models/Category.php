<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar',
        'name_en',
        'image',
        'parent_id',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getImageUrlAttribute()
    {
        if (isset($this->image)) {
           $img = $this->image;
            return asset('storage/' . $img);
        }
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

    public function scopeParent($query, $parentId)
    {
        return $query->when($parentId, function ($q) use ($parentId) {
            $q->where('parent_id', $parentId);
        });
    }

    public function scopeHasProducts($query)
    {
        return $query->whereHas('products');
    }

    public function scopeHasChildren($query)
    {
        return $query->whereHas('children');
    }
}
