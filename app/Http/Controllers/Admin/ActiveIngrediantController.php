<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GetActiveIngredientsRequest;
use App\Http\Requests\Admin\StoreActiveIngrediantRequest;
use App\Http\Requests\Admin\UpdateActiveIngrediantRequest;
use App\Http\Resources\Admin\ActiveIngrediantResource;
use App\Services\Admin\ActiveIngrediantService;

class ActiveIngrediantController extends Controller
{
    public function __construct(protected ActiveIngrediantService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GetActiveIngredientsRequest $request)
    {
        $ingredients = $this->service->getAllActiveIngredientsPagenated($request->search);
        return ActiveIngrediantResource::collection($ingredients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActiveIngrediantRequest $request)
    {
        $ingredient = $this->service->createActiveIngredient($request->validated());
        return new ActiveIngrediantResource($ingredient);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ingredient = $this->service->getActiveIngredientById($id);
        return new ActiveIngrediantResource($ingredient);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActiveIngrediantRequest $request, string $id)
    {
        $ingredient = $this->service->updateActiveIngredient($id, $request->validated());
        return new ActiveIngrediantResource($ingredient);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->service->deleteActiveIngredient($id);
        return response()->noContent();
    }
}
