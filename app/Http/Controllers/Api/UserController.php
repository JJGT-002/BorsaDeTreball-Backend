<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\Company;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller {

    public function index(): UserCollection {
        $users = User::paginate(10);
        return new UserCollection($users);
    }

    public function store(UserRequest $request): JsonResponse {
        try {
            $validatedData = $request->validated();
            $user = User::create([
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'address' => $validatedData['address'],
                'role' => $validatedData['role'],
            ]);

            if ($validatedData['role'] === 'company') {
                Company::create([
                    'user_id' => $user->id,
                    'name' => $validatedData['name'],
                    'cif' => $validatedData['cif'],
                    'contactName' => $validatedData['contactName'],
                    'companyWeb' => $validatedData['companyWeb'],
                ]);
            }
            return response()->json([
                'message' => 'User created successfully',
                'data' => new UserResource($user)
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->validator->errors()->messages()
            ], 422);
        }
    }


    public function show(User $user) {
        $userResource = new UserResource($user);
        return $this->addStatus($userResource);
    }

    public function update(UserRequest $request, User $user): JsonResponse {
        try {
            $validatedData = $request->validated();

            $user->update([
                'password' => bcrypt($validatedData['password']),
                'address' => $validatedData['address'],
                'role' => $validatedData['role'],
                'accept' => $validatedData['accept'] ?? false,
                'observations' => $validatedData['observations'] ?? 'Sin observaciones',
                'isDeleted' => $validatedData['isDeleted'] ?? false,
            ]);
            return (new UserResource($user))->response()->setStatusCode(ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to update user',
                'message' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(User $user): JsonResponse {
        try {
            $user->delete();
            return response()->json([
                'message' => 'User deleted successfully',
                'data' => $user->id
            ]);
        } catch (Exception) {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }
    }

    private function addStatus($resource) {
        $data = $resource->toArray(request());
        $data['status'] = 'success';
        return $data;
    }
}
