<?php

namespace App\Services\Website;

use App\Models\Product;

class ProductService
{
    /**
     * Create a new class instance.
     */
    public function getProducts($filters = [])
    {
        $query = Product::query();

        // Basic filtering example
        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }
        
        if (isset($filters['search'])) {
             $query->where(function($q) use ($filters) {
                 $q->where('name_en', 'like', "%{$filters['search']}%")
                   ->orWhere('name_ar', 'like', "%{$filters['search']}%");
             });
        }

        return $query->paginate(12);
    }

    public function getProduct($id)
    {
        return Product::findOrFail($id);
    }
}
