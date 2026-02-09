<?php

namespace App\Services\Website;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

class HomeService
{
    /**
     * Create a new class instance.
     */
    public function getHomeData()
    {
        return [
            'sliders' => [], 
            'categories' => $this->getCategories(),
            'brands' => $this->getBrands(),
            'featuredProducts' => $this->getBestSellers(),
            'newArrivals' => $this->getNewArrivals(),
        ];
    }

    public function getNewArrivals()
    {
        return Product::latest()->take(4)->get();
    }

    public function getCategories()
    {
        return Category::take(6)->get();
    }

    public function getBrands()
    {
        return Brand::take(8)->get();
    }

    public function getBestSellers()
    {
        // For now, returning featured products as best sellers
        return Product::take(4)->get();
    }
}
