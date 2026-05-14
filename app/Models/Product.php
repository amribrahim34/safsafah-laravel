<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'slug_ar',
        'slug_en',
        'brand_id',
        'price',
        'image',
        'sku',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
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

    public function getRatingAttribute()
    {
        return $this->reviews()->avg('rating');
    }

    public function getRatingCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function getIsInWishlistAttribute()
    {
        return $this->wishLists()->where('user_id', auth('sanctum')->id())->exists();
    }

    public function getIsRecommendedAttribute(): ?bool
    {
        $user = auth('sanctum')->user();

        if (! $user) {
            return false;
        }

        // Load the beauty profile and its ingredient relations once per request.
        // Eloquent caches the results on the model instance, so subsequent calls
        // for the same user are resolved in-memory without additional queries.
        $user->loadMissing([
            'beautyProfile.preferredIngredients',
            'beautyProfile.avoidedIngredients',
        ]);

        $beautyProfile = $user->beautyProfile;

        if (! $beautyProfile) {
            return false;
        }

        $productSkinTypeIds     = $this->skinTypes->pluck('id');
        $productIngredientIds   = $this->activeIngredients->pluck('id');

        $preferredIngredientIds = $beautyProfile->preferredIngredients->pluck('id');
        $avoidedIngredientIds   = $beautyProfile->avoidedIngredients->pluck('id');

        // Disqualify immediately if the product contains any avoided ingredient.
        if ($productIngredientIds->intersect($avoidedIngredientIds)->isNotEmpty()) {
            return false;
        }

        // Recommend when the product matches the user's skin type OR a preferred ingredient.
        $matchesSkinType    = $productSkinTypeIds->contains($beautyProfile->skin_type_id);
        $matchesIngredient  = $productIngredientIds->intersect($preferredIngredientIds)->isNotEmpty();

        return $matchesSkinType || $matchesIngredient;
    }
}
