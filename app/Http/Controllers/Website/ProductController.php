<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Product\GetListRequest;
use Illuminate\Http\Request;
use App\Http\Resources\Website\ProductResource;
use App\Services\Website\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(GetListRequest $request)
    {
        $products = $this->productService->getProducts($request->validated());
        return ProductResource::collection($products);
    }

    public function show($id)
    {
         $product = $this->productService->getProduct($id);
         return new ProductResource($product);
    }}
