<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'email' => 'nullable|email|unique:users,email|max:255',
                'password' => 'nullable|string|min:4',
                'address' => 'nullable|string|max:255',
                'observations' => 'nullable|string',
                'isDeleted' => 'nullable|boolean',
            ];
        }
        return [
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:4',
            'address' => 'required|string|max:255',
            'accept' => 'required|accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'El campo email es obligatorio.',
            'email.email' => 'El campo email debe ser una dirección de correo electrónico válida.',
            'email.unique' => 'La dirección de correo electrónico ya está en uso.',
            'email.max' => 'El campo email no puede ser mayor que :max caracteres.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.string' => 'El campo contraseña debe ser una cadena de caracteres.',
            'password.min' => 'El campo contraseña debe tener al menos :min caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
            'address.required' => 'El campo dirección es obligatorio.',
            'address.string' => 'El campo dirección debe ser una cadena de caracteres.',
            'address.max' => 'El campo dirección no puede ser mayor que :max caracteres.',
            'accept.required' => 'El campo de condiciones de uso se debe de cumplimentar.',
            'accept.accepted' => 'Se deben aceptar las condiciones de uso.',
            'observations.string' => 'El campo observaciones debe ser una cadena de caracteres.',
            'isDeleted.boolean' => 'El campo isDeleted debe ser verdadero o falso.',
        ];
    }
}
