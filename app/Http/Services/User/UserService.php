<?php

declare(strict_types=1);

namespace App\Http\Services\User;

use App\DTO\Api\User\UserDTO;
use App\Models\User;

class UserService
{
    public function save(UserDTO $dto): User
    {
        $user = new User();
        $user->name = $dto->name;
        $user->surname = $dto->surname;
        $user->email = $dto->email;
        $user->password = $dto->password;
        $user->phone = $dto->phone;
        $user->avatar = $dto->avatar;
        $user->save();

        return $user;
    }

    public function update(UserDTO $dto, User $user): User
    {
        $user->fill([
            'name' => $dto->name ?? $user->name,
            'surname' => $dto->surname ?? $user->surname,
            'email' => $dto->email ?? $user->email,
            'phone' => $dto->phone ?? $user->phone,
            'avatar' => $dto->avatar ?? $user->avatar
        ]);

        $user->save();

        return $user;
    }
}
