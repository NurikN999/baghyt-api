<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\Api\User\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\StoreUserRequest;
use App\Http\Requests\Api\V1\User\UpdateUserRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Http\Services\User\UserService;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    )
    {

    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userService->save(UserDTO::fromRequest($request));

        return $this->successResponse(
            data: [
                'user' => new UserResource($user)
            ],
            message: 'User created successfully.',
            code: 201
        );
    }

    public function show(User $user): JsonResponse
    {
        return $this->successResponse(
            data: [
                'user' => new UserResource($user)
            ],
            message: 'User retrieved successfully.',
            code: 200
        );
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user = $this->userService->update(UserDTO::fromRequest($request), $user);

        return $this->successResponse(
            data: [
                'user' => new UserResource($user)
            ],
            message: 'User updated successfully.',
        );
    }

}
