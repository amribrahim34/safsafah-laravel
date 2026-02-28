<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\BeautyProfile\StoreBeautyProfileRequest;
use App\Http\Resources\Website\BeautyProfileResource;
use App\Services\Website\BeautyProfileService;
use Illuminate\Http\Request;

class BeautyProfileController extends Controller
{
    protected $beautyProfileService;

    public function __construct(BeautyProfileService $beautyProfileService)
    {
        $this->beautyProfileService = $beautyProfileService;
    }

    public function store(StoreBeautyProfileRequest $request)
    {
        $profile = $this->beautyProfileService->storeProfile($request->validated());
        return new BeautyProfileResource($profile);
    }
    
    public function show()
    {
        $profile = $this->beautyProfileService->getProfile();
        return new BeautyProfileResource($profile);
    }
}