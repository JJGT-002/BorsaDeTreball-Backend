<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules() {
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return ['email' => 'nullable|email|unique:users,email|max:255',
                'password' => 'nullable|string|min:4',
                'address' => 'nullable|string|max:255',
                'name' => 'nullable|string|max:50',
                'surnames' => 'nullable|string|max:200',
                'urlCV' => 'nullable|url',
                'endDate' => 'nullable|numeric',
                'isValid' => 'nullable|boolean',
                'accept' => 'nullable|boolean',
                'observations' => 'nullable|string',
                'isDeleted' => 'nullable|boolean',
            ];
        }
        return [
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:4',
            'address' => 'required|string|max:255',
            'name' => 'required|string|max:50',
            'surnames' => 'required|string|max:200',
            'urlCV' => 'nullable|url',
            'cycle_endDate_ids' => ['required','array'],
            'cycle_endDate_ids.*.cycle' => 'required|exists:cycles,id',
            'cycle_endDate_ids.*.endDate' => ['nullable','numeric']
        ];
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
            'urlCV.url' => 'El campo currículum del estudiante debe ser una URL válida.',
            //'endDate.required' => 'El año de finalización es obligatorio.',
            //'endDate.numeric' => 'El año de finalización debe ser un año (número).',
            //'cycle_ids.array' => 'El campo cycle_ids debe ser un array.',
            //'cycle_ids.*.exists' => 'Uno o más elementos de cycle_ids no son válidos.',
        ];
    }
}
