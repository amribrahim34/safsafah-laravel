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
            'sliders' => [], // Placeholder for sliders
            'categories' => Category::take(6)->get(),
            'brands' => Brand::take(8)->get(),
            'featuredProducts' => Product::take(4)->get(),
            'newArrivals' => Product::latest()->take(4)->get(),
        ];
    }
}
