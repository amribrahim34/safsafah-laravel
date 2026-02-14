<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SkinConcernResource;
use App\Http\Resources\Admin\SkinTypesResource;
use App\Http\Resources\Website\ActiveIngredientResource;
use App\Http\Resources\Website\BrandResource;
use App\Http\Resources\Website\CategoryResource;
use App\Services\Website\FilterService;
use Illuminate\Http\Request;

class FiltersController extends Controller
{
    public function __construct(private FilterService $filterService)
    {
        
    }
    public function getCategories()
    {
        $categories = $this->filterService->getCategories();
        return CategoryResource::collection($categories);
    }

    public function getBrands()
    {
        $brands = $this->filterService->getBrands();
        return BrandResource::collection($brands);
    }

    public function getSkinTypes()
    {
        $skinTypes = $this->filterService->getSkinTypes();
        return SkinTypesResource::collection($skinTypes);
    }

    public function getSkinConcerns()
    {
        $skinConcerns = $this->filterService->getSkinConcerns();
        return SkinConcernResource::collection($skinConcerns);
    }

    public function getActiveIngredients()
    {
        $activeIngredients = $this->filterService->getActiveIngredients();
        return ActiveIngredientResource::collection($activeIngredients);
    }
}
