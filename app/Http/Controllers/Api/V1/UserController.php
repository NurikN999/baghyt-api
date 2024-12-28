<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\UserResource;
use App\Http\Services\User\UserService;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    )
    {
        
    }

    public function show(User $user)
    {
        return $this->successResponse(
            data: new UserResource($user),
            message: 'User retrieved successfully.',
            code: 200
        );
    }
}
