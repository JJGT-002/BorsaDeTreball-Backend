<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller {

    public function index(): UserCollection {
        $users = User::paginate(10);
        return new UserCollection($users);
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

    private function addStatus($resource) {
        $data = $resource->toArray(request());
        $data['status'] = 'success';
        return $data;
    }
}
