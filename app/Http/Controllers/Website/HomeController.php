<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
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
        return response()->json(['data' => $this->homeService->getNewArrivals()]);
    }

    public function categories()
    {
        return response()->json(['data' => $this->homeService->getCategories()]);
    }

    public function brands()
    {
        return response()->json(['data' => $this->homeService->getBrands()]);
    }

    public function bestSellers()
    {
        return response()->json(['data' => $this->homeService->getBestSellers()]);
    }
}
