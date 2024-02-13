<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest {
    public function authorize() {
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
            'cif' => 'required|string|size:9|regex:/^[ABCDEFGHJKLMNPQRSUVW]\d{7}[0-9A-J]$/',
            'contactName' => 'required|string|max:20',
            'companyWeb' => 'required|url',
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

            //Mensajes de validación para el company
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El campo nombre debe ser una cadena de caracteres.',
            'name.max' => 'El campo nombre no puede ser mayor que :max caracteres.',
            'cif.required' => 'El campo CIF es obligatorio.',
            'cif.string' => 'El campo CIF debe ser una cadena de caracteres.',
            'cif.regex' => 'El CIF introducido no es válido.',
            'contactName.required' => 'El campo nombre de contacto es obligatorio.',
            'contactName.string' => 'El campo nombre de contacto debe ser una cadena de caracteres.',
            'contactName.max' => 'El campo nombre de contacto no puede ser mayor que :max caracteres.',
            'companyWeb.required' => 'El campo web de la compañía es obligatorio.',
            'companyWeb.url' => 'El campo web de la compañía debe ser una URL válida.',
        ];
    }
}
