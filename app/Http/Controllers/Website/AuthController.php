<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Auth\LoginRequest;
use App\Http\Requests\Website\Auth\RegisterRequest;
use App\Http\Resources\Website\UserResource;
use App\Services\Website\AuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        try {
            $data = $this->authService->login($request->validated());
            return response()->json([
                'user' => new UserResource($data['user']),
                'token' => $data['token'],
            ]);
        } catch (AuthenticationException $e) {
            return response()->json(['message' => __('website/auth.wrong_credentials')], 401);
        }
    }

    public function register(RegisterRequest $request)
    {
        $data = $this->authService->register($request->validated());
        return response()->json([
            'user' => new UserResource($data['user']),
            'token' => $data['token'],
        ], 201);
    }}
