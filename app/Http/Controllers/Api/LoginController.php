<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginController extends Controller {

    /**
     * @OA\Post(
     * path="/login",
     * summary="Sign in",
     * description="Login by email, password",
     * operationId="authLogin",
     * tags={"auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *       @OA\Property(property="persistent", type="boolean", example="true"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        if ($user->role === 'student') {
            $idType = $user->Student->id;
        } else if ($user->role === 'company') {
            $idType = $user->Company->id;
        } else {
            $idType = $user->id;
        }

        return response()->json([
            'token' => $user->token,
            'role' => $user->role,
            'idType' => $idType,
            'id' => $user->id
        ]);
    }

    public function redirectToGoogle(): RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(): JsonResponse
    {
        try {
            $user = Socialite::driver('google')->user();

            $existingUser = User::where('email', $user->email)->first();

            if ($existingUser) {
                Auth::login($existingUser);
            }
            return response()->json([
                'message' => 'Login with Google successfully',
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to login with Google',
                'message' => $e->getMessage()
            ], 401);
        }
    }
}
