<?php

namespace App\Services\Website;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SkinType;
use App\Models\SkinConcern;
use App\Models\ActiveIngredient;

class FilterService
{
    public function getCategories()
    {
        $categories = Category::select('id', 'name_ar', 'name_en', 'parent_id')
        ->with('children')
        ->hasProducts()
        ->get();
        return $categories;
    }

    public function getBrands()
    {
        $brands = Brand::select('id', 'name_ar', 'name_en', 'logo')
        ->hasProducts()
        ->get();
        return $brands;
    }

    public function getSkinTypes()
    {
        $skinTypes = SkinType::select('id', 'name_ar', 'name_en')
        ->hasProducts()
        ->get();
        return $skinTypes;
    }   

    public function getSkinConcerns()
    {
        $skinConcerns = SkinConcern::select('id', 'name_ar', 'name_en')
        ->hasProducts()
        ->get();
        return $skinConcerns;
    }

    public function getActiveIngredients()
    {
        $activeIngredients = ActiveIngredient::select('id', 'name_ar', 'name_en')
        ->hasProducts()
        ->get();
        return $activeIngredients;
    }
}
