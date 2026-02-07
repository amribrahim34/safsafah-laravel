<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\ProductService;
use App\Http\Requests\Admin\GetProductsRequest;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Http\Resources\Admin\ProductResource;

class ProductController extends Controller
{
    public function __construct(protected ProductService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GetProductsRequest $request)
    {
        $products = $this->service->getAllProductsPaginated(
            $request->search,
            $request->category_id,
            $request->brand_id
        );
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = $this->service->createProduct($request->validated());
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->service->getProductById($id);
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = $this->service->updateProduct($id, $request->validated());
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->service->deleteProduct($id);
        return response()->noContent();
    }
}
