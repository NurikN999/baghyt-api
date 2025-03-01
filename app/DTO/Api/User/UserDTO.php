<?php

namespace App\DTO\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class UserDTO
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $surname,
        public readonly ?string $email,
        public readonly ?string $password,
        public readonly ?string $phone,
        public readonly ?string $avatar
    )
    {

    }

    public static function fromRequest(FormRequest $request): self
    {
        return new self(
            $request->validated('name') ?? null,
            $request->validated('surname') ?? null,
            $request->validated('email') ?? null,
            $request->validated('password') ?? null,
            $request->validated('phone') ?? null,
            $request->validated('avatar') ?? null,
        );
    }
}
