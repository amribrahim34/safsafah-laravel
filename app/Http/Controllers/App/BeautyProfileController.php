<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\BeautyProfile\StoreBeautyProfileRequest;
use App\Http\Resources\App\BeautyProfileResource;
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