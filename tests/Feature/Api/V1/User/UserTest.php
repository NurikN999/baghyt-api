<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1\User;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function it_should_return_a_user()
    {
        $user = User::factory()->create();

        $response = $this->get('/api/v1/users/' . $user->id);

        $response->assertStatus(200);

        $response->assertExactJson([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'surname' => $user->surname,
                'email' => $user->email,
                'phone' => $user->phone,
            ],
            'message' => 'User retrieved successfully.',
            'status' => 'success',
        ]);
    }
}