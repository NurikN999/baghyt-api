<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use DatabaseTransactions;

    /** @test */
    public function it_test_login()
    {
        $user = User::factory()->create();

        $response = $this->post('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);

        $response->assertExactJson([
            'data' => [
                'token' => $response['data']['token'],
                'token_type' => 'bearer',
                'expires_in' => 3600,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'surname' => $user->surname,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ]
            ],
            'message' => 'User logged in successfully',
            'status' => 'success'
        ]);
    }

    /** @test */
    public function it_test_register()
    {
        $response = $this->post('/api/v1/auth/register', [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'johndoe@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'phone' => '+1234567890'
        ]);

        $response->assertStatus(201);

        $response->assertExactJson([
            'data' => [
                'token' => $response['data']['token'],
                'token_type' => 'bearer',
                'expires_in' => 3600,
                'user' => [
                    'id' => $response['data']['user']['id'],
                    'name' => 'John',
                    'surname' => 'Doe',
                    'email' => 'johndoe@gmail.com',
                    'phone' => '+1234567890',
                ]
            ],
            'message' => 'User registered successfully',
            'status' => 'success'
        ]);
    }
}