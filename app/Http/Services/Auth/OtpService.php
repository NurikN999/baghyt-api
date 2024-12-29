<?php

declare(strict_types=1);

namespace App\Http\Services\Auth;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class OtpService
{
    public function generateOtp(string $email): string
    {
        if (App::environment('development')) {
            $otp = '111111';
        } else {
            $otp = (string) rand(100000, 999999);
        }

        Cache::put($this->getCacheKey($email), $otp, 60 * 60);

        return $otp;
    }

    public function validateOtp(string $email, string $otp): bool
    {
        return Cache::get($this->getCacheKey($email)) === $otp;
    }

    public function canGenerateOtp(string $email): bool
    {
        return !Cache::has($this->getThrottleKey($email));
    }

    public function throttleOtpGeneration(string $email): void
    {
        Cache::put($this->getThrottleKey($email), true, 60);
    }

    private function getCacheKey(string $email): string
    {
        return "otp_code_{$email}";
    }

    private function getThrottleKey(string $email): string
    {
        return "otp_throttle_{$email}";
    }
}
