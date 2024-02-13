<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CompanyController extends Controller {

    public function index(): CompanyCollection {
        $companies = Company::paginate(10);
        return new CompanyCollection($companies);
    }

    public function store(CompanyRequest $request): JsonResponse {
        try {
            $validatedData = $request->validated();
            DB::beginTransaction();
            $user = new User([
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'address' => $validatedData['address'],
                'role' => 'company',
            ]);
            $user->save();

            $company = new Company([
                'user_id' => $user->id,
                'name' => $validatedData['name'],
                'cif' => $validatedData['cif'],
                'contactName' => $validatedData['contactName'],
                'companyWeb' => $validatedData['companyWeb'],
            ]);
            $company->save();
            DB::commit();
            return response()->json([
                'message' => 'Company created successfully',
                'data' => new CompanyResource($company)
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to create company',
                'message' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Company $company) {
        $companyResource = new CompanyResource($company);
        return $this->addStatus($companyResource);
    }

    public function update(CompanyRequest $request, Company $company): JsonResponse {
        try {
            $validatedData = $request->validated();

            $company->name = $validatedData['name'];
            $company->cif = $validatedData['cif'];
            $company->contactName = $validatedData['contactName'];
            $company->companyWeb = $validatedData['companyWeb'];

            $company->save();

            return response()->json([
                'message' => 'Company updated successfully',
                'data' => new CompanyResource($company)
            ], ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to update company',
                'message' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Company $company): JsonResponse {
        try {
            $company->delete();
            return response()->json([
                'message' => 'Company deleted successfully',
                'data' => $company->id
            ]);
        } catch (Exception) {
            return response()->json([
                'error' => 'Company not found'
            ], 404);
        }
    }

    private function addStatus($resource) {
        $data = $resource->toArray(request());
        $data['status'] = 'success';
        return $data;
    }
}
