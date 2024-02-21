<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\DefaultCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller {

    public function index(): DefaultCollection {
        $users = User::paginate(10);
        return new DefaultCollection($users);
    }

    public function store(UserRequest $request): JsonResponse {
        try {
            DB::beginTransaction();
            do {
                $numbers = str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT);
                $token = $numbers . '|' . Str::random(40);
            } while (User::where('token', $token)->exists());
            $user = new User([
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'address' => $request['address'],
                'accept' => $request['accept'],
                'role' => 'responsible',
                'isActivated' => 1,
                'token' => $token,
            ]);
            $user->save();

            DB::commit();
            return response()->json([
                'message' => 'User created successfully',
                'data' => new UserResource($user)
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to create user',
                'message' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(User $user) {
        $userResource = new UserResource($user);
        return $this->addStatus($userResource);
    }

    public function update(UserRequest $request, User $user): JsonResponse {
        try {
            foreach ($request as $key => $value) {
                if (isset($request[$key])) {
                    $user->$key = $value;
                }
            }
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

    public function activarUsuario($id): void
    {
        $user = User::find($id);
        $user->isActivated = 1;
        $user->save();
    }

    private function addStatus($resource) {
        $data = $resource->toArray(request());
        $data['status'] = 'success';
        return $data;
    }
}
