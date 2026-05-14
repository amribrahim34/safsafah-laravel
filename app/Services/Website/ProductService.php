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
        $query = Product::query()->with(['skinTypes', 'activeIngredients']);

        if (isset($filters['categoryIds'])) {
            $query->whereHas('categories', fn($q) => $q->whereIn('categories.id', $filters['categoryIds']));
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
            $ids = Product::search($filters['searchQuery'])->keys();
            $query->whereIn('id', $ids);
        }

        if (!empty($filters['recommended'])) {
            $this->applyRecommendedFilter($query);
        }

        $perPage = $filters['limit'] ?? 12;

        $data = $query->paginate($perPage);
        return $data;
    }

    private function applyRecommendedFilter($query): void
    {
        $user = auth('sanctum')->user();

        if (!$user) {
            return;
        }

        $user->loadMissing([
            'beautyProfile.preferredIngredients',
            'beautyProfile.avoidedIngredients',
        ]);

        $beautyProfile = $user->beautyProfile;

        if (!$beautyProfile) {
            return;
        }

        $preferredIngredientIds = $beautyProfile->preferredIngredients->pluck('id')->toArray();
        $avoidedIngredientIds   = $beautyProfile->avoidedIngredients->pluck('id')->toArray();

        if (!empty($avoidedIngredientIds)) {
            $query->whereDoesntHave('activeIngredients', fn($q) =>
                $q->whereIn('active_ingredients.id', $avoidedIngredientIds)
            );
        }

        $query->where(function ($q) use ($beautyProfile, $preferredIngredientIds) {
            $q->whereHas('skinTypes', fn($sq) =>
                $sq->where('skin_types.id', $beautyProfile->skin_type_id)
            );
            if (!empty($preferredIngredientIds)) {
                $q->orWhereHas('activeIngredients', fn($sq) =>
                    $sq->whereIn('active_ingredients.id', $preferredIngredientIds)
                );
            }
        });
    }

    public function getProduct($selector)
    {
        return Product::with(['skinTypes', 'activeIngredients', 'skinConcerns'])
            ->where('slug_ar', $selector)
            ->orWhere('slug_en', $selector)
            ->orWhere('id', $selector)
            ->firstOrFail();
    }
}
