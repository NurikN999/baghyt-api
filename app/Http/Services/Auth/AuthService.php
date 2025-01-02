<?php

declare(strict_types=1);

namespace App\Http\Services\Auth;

use App\DTO\Api\Auth\AuthDTO;
use App\Http\Resources\Api\V1\UserResource;
use App\Mail\PasswordRestoreOtpMail;
use App\Models\User;
use App\Http\Services\Auth\OtpService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{

    public function __construct(
        protected OtpService $otpService
    )
    {
        
    }

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

    public function sendPasswordChangeCode(array $data)
    {
        $otp = $this->otpService->generateOtp($data['email']);
        $this->otpService->throttleOtpGeneration($data['email']);

        Cache::put("password_change_otp_{$data['email']}", $otp, 10 * 60);

        Mail::to($data['email'])->send(new PasswordRestoreOtpMail($otp));

        return [
            'message' => 'Verification code sent successfully'
        ];
    }

    public function verifyPasswordChangeCode(array $data)
    {
        $cachedOtp = Cache::get("password_change_otp_{$data['email']}");

        if (!$cachedOtp || $cachedOtp !== $data['code']) {
            return [
                'error' => 'Invalid verification code'
            ];
        }

        $token = bin2hex(random_bytes(16));
        Cache::put("password_change_token_{$data['email']}", $token, 10 * 60);

        return [
            'token' => $token
        ];
    }

    public function changePassword(array $data)
    {
        $cachedToken = Cache::get("password_change_token_{$data['email']}");

        if (!$cachedToken || $cachedToken !== $data['token']) {
            return [
                'error' => 'Invalid token'
            ];
        }

        $user = User::where('email', $data['email'])->first();
        $user->update([
            'password' => bcrypt($data['password'])
        ]);
        Cache::forget("password_change_token_{$data['email']}");
        Cache::forget("password_change_otp_{$data['email']}");

        return [
            'message' => 'Password changed successfully'
        ];
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }

}