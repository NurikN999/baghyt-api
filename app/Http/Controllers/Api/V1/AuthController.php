<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\Api\Auth\AuthDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\PasswordChangeCodeRequest;
use App\Http\Requests\Api\V1\Auth\PasswordChangeRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Http\Requests\Api\V1\Auth\VerifyPasswordChangeCodeRequest;
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

    public function sendPasswordChangeCode(PasswordChangeCodeRequest $request)
    {
        $result = $this->authService->sendPasswordChangeCode($request->validated());

        if ($result) {
            return $this->successResponse([], $result['message'], 200);
        }

        return $this->errorResponse('Problem occured while sending otp code', 400);
    }

    public function verifyPasswordChangeCode(VerifyPasswordChangeCodeRequest $request)
    {
        $result = $this->authService->verifyPasswordChangeCode($request->validated());

        if ($result['token']) {
            return $this->successResponse($result, code: 200);
        }

        return $this->errorResponse($result['error'], 400);
    }

    public function changePassword(PasswordChangeRequest $request)
    {
        $result = $this->authService->changePassword($request->validated());

        if ($result['message']) {
            return $this->successResponse([], $result['message'], 200);
        }

        return $this->errorResponse($result['error'], 400);
    }

    public function logout()
    {
        $this->authService->logout();

        return $this->successResponse([], 'User logged out successfully', 200);
    }
}
