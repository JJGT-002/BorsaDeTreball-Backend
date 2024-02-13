<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler {

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void {
        $this->renderable(function (Throwable $exception) {
            if ($exception instanceof ModelNotFoundException) {
                return response()->json(['error' => 'Elemento no encontrado'], 404);
            }

            if ($exception instanceof AuthenticationException) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            if ($exception instanceof ValidationException) {
                return $this->handleValidationException($exception);
            }

        });
    }

    protected function handleValidationException(ValidationException $exception) {
        return response()->json(['error' => 'Datos no válidos', 'details' => $exception->errors()], 400);
    }
}
