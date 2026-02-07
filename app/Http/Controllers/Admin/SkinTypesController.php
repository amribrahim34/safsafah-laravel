<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\SkinTypeService;
use App\Http\Requests\Admin\GetSkinTypesRequest;
use App\Http\Requests\Admin\StoreSkinTypesRequest;
use App\Http\Requests\Admin\UpdateSkinTypesRequest;
use App\Http\Resources\Admin\SkinTypesResource;

class SkinTypesController extends Controller
{
    public function __construct(private SkinTypeService $skinTypeService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GetSkinTypesRequest $request)
    {
        $skinTypes = $this->skinTypeService->getAllSkinTypesPagenated($request->search);
        return SkinTypesResource::collection($skinTypes);
    }

    /**
     * Get all skin types for select dropdown (unpaginated).
     */
    public function select()
    {
        $skinTypes = $this->skinTypeService->getAllSkinTypesForSelect();
        return SkinTypesResource::collection($skinTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSkinTypesRequest $request)
    {
        $skinType = $this->skinTypeService->createSkinType($request->validated());
        return new SkinTypesResource($skinType);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $skinType = $this->skinTypeService->getSkinTypeById($id);
        return new SkinTypesResource($skinType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSkinTypesRequest $request, string $id)
    {
        $skinType = $this->skinTypeService->updateSkinType($id, $request->validated());
        return new SkinTypesResource($skinType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->skinTypeService->deleteSkinType($id);
        return response()->noContent();
    }
}
