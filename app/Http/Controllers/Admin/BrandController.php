<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\BrandService;
use App\Http\Requests\Admin\GetBrandsRequest;
use App\Http\Requests\Admin\StoreBrandRequest;
use App\Http\Requests\Admin\UpdateBrandRequest;
use App\Http\Resources\Admin\BrandResource;

class BrandController extends Controller
{
    public function __construct(private BrandService $brandService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GetBrandsRequest $request)
    {
        $brands = $this->brandService->getAllBrandsPagenated($request->search);
        return BrandResource::collection($brands);
    }

    /**
     * Get all brands for select dropdown (unpaginated).
     */
    public function select()
    {
        $brands = $this->brandService->getAllBrandsForSelect();
        return BrandResource::collection($brands);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $brand = $this->brandService->createBrand($request->validated());
        return new BrandResource($brand);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = $this->brandService->getBrandById($id);
        return new BrandResource($brand);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, string $id)
    {
        $brand = $this->brandService->updateBrand($id, $request->validated());
        return new BrandResource($brand);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->brandService->deleteBrand($id);
        return response()->noContent();
    }
}
