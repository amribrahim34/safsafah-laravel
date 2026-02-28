<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Website\Profile\UpdateProfileRequest;
use App\Http\Resources\Website\AddressResource;
use App\Http\Resources\Website\UserResource;
use App\Services\Website\ProfileService;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show(Request $request)
    {
        $user = $this->profileService->getProfile($request->user());
        return new UserResource($user);
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $this->profileService->updateProfile($request->user(), $request->validated());
        return new UserResource($user);
    }

    public function addresses(Request $request)
    {
        $addresses = $this->profileService->getAddresses($request->user());
        // Return collection. creating AddressResource might be nice but standard JSON or implicit resource is fine if no complex transformation.
        // I'll return a simple response or creating a resource if not exists. I don't see AddressResource in task.md explicitly.
        // Let's check if I have AddressResource. If not, simple JSON or generic JsonResource.
        return  AddressResource::collection($addresses);
    }}
