<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CompanyResource;
use App\Http\Services\Company\CompanyService;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct(
        protected CompanyService $companyService
    )
    {
        
    }

    public function index()
    {
        $companies = Company::paginate(10);

        return $this->successResponse(
            CompanyResource::collection($companies),
            'Companies retrieved successfully.',
            200
        );
    }

    public function show(Company $company)
    {
        return $this->successResponse(
            new CompanyResource($company),
            'Company retrieved successfully.',
            200
        );
    }
}
