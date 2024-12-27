<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\Api\Auth\AuthDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Http\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    )
    {
        
    }

    public function register(RegisterRequest $request)
    {
        $data = $this->authService->register(AuthDTO::fromRequest($request));

        return $this->successResponse($data, 'User registered successfully', 201);
    }

    public function login(LoginRequest $request)
    {
        $data = $this->authService->login(AuthDTO::fromRequest($request));

        if (isset($data['error'])) {
            return $this->errorResponse($data['error'], 403);
        }

        return $this->successResponse($data, 'User logged in successfully');
    }
}
