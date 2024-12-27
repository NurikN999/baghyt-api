<?php


declare(strict_types=1);

namespace App\DTO\Api\Auth;
use Illuminate\Foundation\Http\FormRequest;

final class AuthDTO
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $surname = null,
        public readonly ?string $email = null,
        public readonly ?string $password = null,
        public readonly ?string $phone = null
    )
    {
        
    }

    public static function fromRequest(FormRequest $formRequest): self
    {
        return new self(
            $formRequest->validated('name') ?? null,
            $formRequest->validated('surname') ?? null,
            $formRequest->validated('email') ?? null,
            $formRequest->validated('password') ?? null,
            $formRequest->validated('phone') ?? null
        );
    } 

}