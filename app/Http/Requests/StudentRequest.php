<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array
    {
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'email' => 'nullable|email|unique:users,email|max:255',
                'password' => 'nullable|string|min:4',
                'address' => 'nullable|string|max:255',
                'name' => 'nullable|string|max:50',
                'surnames' => 'nullable|string|max:200',
                'urlCV' => 'nullable|url',
                'isActivated' => 'nullable|boolean',
                'cycle_endDate_ids' => ['nullable','array'],
                'cycle_endDate_ids.*.cycle' => 'nullable|exists:cycles,id',
                'cycle_endDate_ids.*.endDate' => ['nullable','numeric'],
                'isValid' => 'nullable|boolean',
            ];
        }
        return [
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:4',
            'address' => 'required|string|max:255',
            'accept' => 'required|accepted',
            'name' => 'required|string|max:50',
            'surnames' => 'required|string|max:200',
            'urlCV' => 'nullable|url',
            'cycle_endDate_ids' => ['required','array'],
            'cycle_endDate_ids.*.cycle' => 'required|exists:cycles,id',
            'cycle_endDate_ids.*.endDate' => ['nullable','numeric']
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

            //Mensajes de validación para el student
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El campo nombre debe ser una cadena de caracteres.',
            'name.max' => 'El campo nombre no puede ser mayor que :max caracteres.',
            'surnames.required' => 'El campo apellidos es obligatorio.',
            'surnames.string' => 'El campo apellidos debe ser una cadena de caracteres.',
            'surnames.max' => 'El campo apellidos no puede ser mayor que :max caracteres.',
            'urlCV.url' => 'El campo currículum del estudiante debe ser una URL válida.',
            'cycle_endDate_ids.required' => 'Es obligatorio que un alumno tenga ciclos.',
            'cycle_endDate_ids.array' => 'El campo cycle_endDate_ids debe ser un array.',
            'cycle_endDate_ids.*.cycle.exists' => 'Uno o más elementos de cycle_endDate_ids no son válidos.',
            'cycle_endDate_ids.*.endDate.numeric' => 'La fecha debe ser un número.'
        ];
    }
}
