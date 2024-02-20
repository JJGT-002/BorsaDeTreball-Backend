<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
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

        // Crear un token de Sanctum
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function redirectToGoogle(): RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $user = Socialite::driver('google')->user();

            $existingUser = User::where('email', $user->email)->first();

            if (!$existingUser) {
                Auth::login($existingUser);

                $token = $existingUser->createToken('Personal Access Token')->plainTextToken;

                $existingUser->forceFill([
                    'remember_token' => $token,
                ])->save();

            }
            Auth::login($existingUser);

            return view('auth.success', ['token' => $token]);
        } catch (Exception $e) {
            return view('auth.error', ['error' => $e->getMessage()]);
        }
    }
}
