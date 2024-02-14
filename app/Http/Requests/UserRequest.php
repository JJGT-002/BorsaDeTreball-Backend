<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
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
                'role' => 'nullable|string|in:admin,responsible,student,company',
                'accept' => 'nullable|boolean',
                'observations' => 'nullable|string',
                'isDeleted' => 'nullable|boolean',
            ];
        }
        return [
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:4',
            'address' => 'required|string|max:255',
            'role' => 'required|string|in:admin,responsible,student,company',
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
            'role.required' => 'El campo rol es obligatorio.',
            'role.string' => 'El campo rol debe ser una cadena de caracteres.',
            'role.in' => 'El campo rol debe ser uno de: admin, responsible, student, company.',
            'accept.boolean' => 'El campo aceptar debe ser verdadero o falso.',
            'observations.string' => 'El campo observaciones debe ser una cadena de caracteres.',
            'isDeleted.boolean' => 'El campo isDeleted debe ser verdadero o falso.',
        ];
    }
}
