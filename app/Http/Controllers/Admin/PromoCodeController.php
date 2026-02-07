<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\PromoCodeService;
use App\Http\Requests\Admin\GetPromoCodesRequest;
use App\Http\Requests\Admin\StorePromoCodeRequest;
use App\Http\Requests\Admin\UpdatePromoCodeRequest;
use App\Http\Resources\Admin\PromoCodeResource;

class PromoCodeController extends Controller
{
    public function __construct(protected PromoCodeService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GetPromoCodesRequest $request)
    {
        $promoCodes = $this->service->getAllPromoCodesPaginated($request->search);
        return PromoCodeResource::collection($promoCodes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePromoCodeRequest $request)
    {
        $promoCode = $this->service->createPromoCode($request->validated());
        return new PromoCodeResource($promoCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $promoCode = $this->service->getPromoCodeById($id);
        return new PromoCodeResource($promoCode);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePromoCodeRequest $request, string $id)
    {
        $promoCode = $this->service->updatePromoCode($id, $request->validated());
        return new PromoCodeResource($promoCode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->service->deletePromoCode($id);
        return response()->noContent();
    }
}
