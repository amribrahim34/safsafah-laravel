<?php

namespace App\Http\Controllers\App;


use App\Http\Controllers\Controller;
use App\Http\Requests\App\Product\GetListRequest;
use App\Http\Resources\App\ProductResource;
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

    public function show($selector)
    {
         $product = $this->productService->getProduct($selector);
         return new ProductResource($product);
    }
}
