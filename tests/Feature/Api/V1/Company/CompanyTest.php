<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1\Company;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class CompanyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_returns_all_companies()
    {
        $user = User::factory()->create();

        $company1 = Company::factory()->create();
        $company2 = Company::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->actingAs($user)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])
            ->get('/api/v1/companies');

        $response->assertStatus(200);

        $response->assertExactJson([
            'data' => [
                [
                    'id' => $company1->id,
                    'name' => $company1->name,
                    'description' => $company1->description,
                ],
                [
                    'id' => $company2->id,
                    'name' => $company2->name,
                    'description' => $company2->description,
                ]
            ],
            'message' => 'Companies retrieved successfully.',
            'status' => 'success',
        ]);
    }
}