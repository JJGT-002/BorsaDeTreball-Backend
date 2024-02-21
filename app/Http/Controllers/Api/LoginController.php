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
     * @throws ValidationException
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
