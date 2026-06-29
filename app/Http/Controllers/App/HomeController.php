<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Resources\App\BrandResource;
use App\Http\Resources\App\CategoryResource;
use App\Http\Resources\App\ProductResource;
use Illuminate\Http\Request;
use App\Services\Website\HomeService;

class HomeController extends Controller
{
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index()
    {
        $data = $this->homeService->getHomeData();
        return response()->json(['data' => $data]);
    }

    public function newArrivals()
    {
        $data = $this->homeService->getNewArrivals();
        return response()->json(['data' => ProductResource::collection($data)]);
    }

    public function categories()
    {
        $data = $this->homeService->getCategories();
        return response()->json(['data' => CategoryResource::collection($data)]);
    }

    public function brands()
    {
        $data = $this->homeService->getBrands();
        return response()->json(['data' => BrandResource::collection($data)]);
    }

    public function bestSellers()
    {
        $data = $this->homeService->getBestSellers();
        return response()->json(['data' => ProductResource::collection($data)]);
    }
}
