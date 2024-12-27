<?php

declare(strict_types=1);

namespace App\Http\Services\Auth;

use App\DTO\Api\Auth\AuthDTO;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{

    public function register(AuthDTO $authDTO)
    {
        $user = User::create([
            'name' => $authDTO->name,
            'surname' => $authDTO->surname,
            'email' => $authDTO->email,
            'phone' => $authDTO->phone,
            'password' => bcrypt($authDTO->password)
        ]);

        $token = JWTAuth::fromUser($user);

        return [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => new UserResource($user)
        ];
    }

    public function login(AuthDTO $authDTO)
    {
        $credentials = [
            'email' => $authDTO->email,
            'password' => $authDTO->password
        ];

        if (!$token = JWTAuth::attempt($credentials)) {
            return [
                'error' => 'Unauthorized'
            ];
        }
    
        return [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => new UserResource(Auth::user())
        ];
    }

}