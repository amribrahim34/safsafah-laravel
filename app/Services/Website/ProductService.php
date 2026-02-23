<?php

namespace App\Services\Website;

use App\Models\Product;

class ProductService
{
    /**
     * Create a new class instance.
     */
    public function getProducts(array $filters = [])
    {
        $query = Product::query();

        if (isset($filters['categoryIds'])) {
            $query->whereIn('category_id', $filters['categoryIds']);
        }

        if (isset($filters['brandIds'])) {
            $query->whereIn('brand_id', $filters['brandIds']);
        }

        if (isset($filters['skinTypeIds'])) {
            $query->whereHas('skinTypes', function ($q) use ($filters) {
                $q->whereIn('skin_types.id', $filters['skinTypeIds']);
            });
        }

        if (isset($filters['skinConcernIds'])) {
            $query->whereHas('skinConcerns', function ($q) use ($filters) {
                $q->whereIn('skin_concerns.id', $filters['skinConcernIds']);
            });
        }

        if (isset($filters['activeIngredientIds'])) {
            $query->whereHas('activeIngredients', function ($q) use ($filters) {
                $q->whereIn('active_ingredients.id', $filters['activeIngredientIds']);
            });
        }

        if (isset($filters['minPrice'])) {
            $query->where('price', '>=', $filters['minPrice']);
        }

        if (isset($filters['maxPrice'])) {
            $query->where('price', '<=', $filters['maxPrice']);
        }

        if (isset($filters['searchQuery'])) {
            $query->search($filters['searchQuery']);
        }

        $perPage = $filters['limit'] ?? 12;

        $data = $query->paginate($perPage);
        return $data;
    }

    public function getProduct($selector)
    {
        return Product::where('slug_ar', $selector)
        ->orWhere('slug_en', $selector)
        ->orWhere('id', $selector)
        ->firstOrFail();
    }
}
