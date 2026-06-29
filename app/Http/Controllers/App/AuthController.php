<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Auth\LoginRequest;
use App\Http\Requests\App\Auth\RegisterRequest;
use App\Http\Resources\App\UserResource;
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
            return response()->json(['message' => __('app/auth.wrong_credentials')], 401);
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
