<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules() {
        $rules = [
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:4',
            'address' => 'required|string|max:255',
        ];

        if ($this->isMethod('post') || $this->isMethod('put') || $this->isMethod('patch')) {
            $rules += [
                'accept' => 'nullable|boolean',
                'observations' => 'nullable|string',
                'isDeleted' => 'nullable|boolean',
            ];
        }

        $rules += [
            'name' => 'required|string|max:50',
            'surnames' => 'required|string|max:200',
            'urlCV' => 'required|url',
        ];
        return $rules;
    }

    public function messages() {
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
            'accept.boolean' => 'El campo aceptar debe ser verdadero o falso.',
            'observations.string' => 'El campo observaciones debe ser una cadena de caracteres.',
            'isDeleted.boolean' => 'El campo isDeleted debe ser verdadero o falso.',

            //Mensajes de validación para el student
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El campo nombre debe ser una cadena de caracteres.',
            'name.max' => 'El campo nombre no puede ser mayor que :max caracteres.',
            'surnames.required' => 'El campo apellidos es obligatorio.',
            'surnames.string' => 'El campo apellidos debe ser una cadena de caracteres.',
            'surnames.max' => 'El campo apellidos no puede ser mayor que :max caracteres.',
            'urlCV.required' => 'El campo web de la compañía es obligatorio.',
            'urlCV.url' => 'El campo web de la compañía debe ser una URL válida.',
        ];
    }
}
