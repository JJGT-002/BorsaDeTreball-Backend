<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\DefaultCollection;
use App\Mail\ActivationEmail;
use App\Models\Company;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CompanyController extends Controller {

    public function index(): DefaultCollection {
        $companies = Company::paginate(10);
        return new DefaultCollection($companies);
    }

    public function store(CompanyRequest $request): JsonResponse {
        try {
            DB::beginTransaction();
            $user = new User([
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'address' => $request['address'],
                'accept' => $request['accept'],
                'role' => 'company',
                'isActivated' => 0,
                'email_verified_at' => now(),
            ]);
            $user->save();

            do {
                $token = $user->createToken('Personal Access Token')->plainTextToken;
            } while (User::where('token', $token)->exists());

            $user->forceFill([
                'token' => $token,
            ])->save();

            $company = new Company([
                'user_id' => $user->id,
                'name' => $request['name'],
                'cif' => $request['cif'],
                'contactName' => $request['contactName'],
                'companyWeb' => $request['companyWeb'],
            ]);
            $company->save();

            Mail::to($user->email)->send(new ActivationEmail($user));

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

    public function update(CompanyRequest $request, Company $company): JsonResponse {
        try {
            $user = $company->user;

            DB::beginTransaction();

            $company->update($request->except('password', 'accept'));

            $user->update([
                'password' => bcrypt($request->input('password')),
                'address' => $request->input('address'),
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Company and user updated successfully',
                'data' => new CompanyResource($company)
            ], ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to update company',
                'message' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function addStatus($resource) {
        $data = $resource->toArray(request());
        $data['status'] = 'success';
        return $data;
    }
}
