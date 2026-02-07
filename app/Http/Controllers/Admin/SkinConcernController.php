<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\SkinConcernService;
use App\Http\Requests\Admin\GetSkinConcernsRequest;
use App\Http\Requests\Admin\StoreSkinConcernRequest;
use App\Http\Requests\Admin\UpdateSkinConcernRequest;
use App\Http\Resources\Admin\SkinConcernResource;

class SkinConcernController extends Controller
{
    public function __construct(private SkinConcernService $skinConcernService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GetSkinConcernsRequest $request)
    {
        $skinConcerns = $this->skinConcernService->getAllSkinConcernsPagenated($request->search);
        return SkinConcernResource::collection($skinConcerns);
    }

    /**
     * Get all skin concerns for select dropdown (unpaginated).
     */
    public function select()
    {
        $skinConcerns = $this->skinConcernService->getAllSkinConcernsForSelect();
        return SkinConcernResource::collection($skinConcerns);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSkinConcernRequest $request)
    {
        $skinConcern = $this->skinConcernService->createSkinConcern($request->validated());
        return new SkinConcernResource($skinConcern);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $skinConcern = $this->skinConcernService->getSkinConcernById($id);
        return new SkinConcernResource($skinConcern);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSkinConcernRequest $request, string $id)
    {
        $skinConcern = $this->skinConcernService->updateSkinConcern($id, $request->validated());
        return new SkinConcernResource($skinConcern);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->skinConcernService->deleteSkinConcern($id);
        return response()->noContent();
    }
}
