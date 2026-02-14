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

        if (isset($filters['categoryId'])) {
            $query->where('category_id', $filters['categoryId']);
        }

        if (isset($filters['brandId'])) {
            $query->where('brand_id', $filters['brandId']);
        }

        if (isset($filters['skinTypeId'])) {
            $query->whereHas('skinTypes', function ($q) use ($filters) {
                $q->where('skin_types.id', $filters['skinTypeId']);
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

    public function getProduct($id)
    {
        return Product::findOrFail($id);
    }
}
