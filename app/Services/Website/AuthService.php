<?php

namespace App\Services\Website;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login(array $credentials)
    {
        $user = isset($credentials['email']) 
        ? User::where('email', $credentials['email'])->first() 
        : User::where('mobile', $credentials['mobile'])->first();
        
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new AuthenticationException(__('website/auth.wrong_credentials'));
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'mobile' => $data['phone'],
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
