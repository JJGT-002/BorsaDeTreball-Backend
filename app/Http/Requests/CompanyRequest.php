<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules()
    {
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'email' => 'nullable|email|unique:users,email|max:255',
                'password' => 'nullable|string|min:4',
                'address' => 'nullable|string|max:255',
                'name' => 'nullable|string|max:50',
                'cif' => [
                    'nullable',
                    'string',
                    'size:9',
                    'regex:/^[AB]\d{7}[0-9A-B]$/',
                ],
                'contactName' => 'nullable|string|max:20',
                'companyWeb' => 'nullable|url',
            ];
        }

        return [
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:4',
            'address' => 'required|string|max:255',
            'name' => 'required|string|max:50',
            'cif' => [
                'required',
                'string',
                'size:9',
                'regex:/^[AB]\d{7}[0-9A-B]$/',
                'unique:companies,cif'
            ],
            'contactName' => 'required|string|max:20',
            'companyWeb' => 'required|url',
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

            //Mensajes de validación para el company
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El campo nombre debe ser una cadena de caracteres.',
            'name.max' => 'El campo nombre no puede ser mayor que :max caracteres.',
            'cif.required' => 'El campo CIF es obligatorio.',
            'cif.string' => 'El campo CIF debe ser una cadena de caracteres.',
            'cif.regex' => 'El CIF introducido no es válido.',
            'cif.unique' => 'Ya hay una empresa con este CIF.',
            'contactName.required' => 'El campo nombre de contacto es obligatorio.',
            'contactName.string' => 'El campo nombre de contacto debe ser una cadena de caracteres.',
            'contactName.max' => 'El campo nombre de contacto no puede ser mayor que :max caracteres.',
            'companyWeb.required' => 'El campo web de la compañía es obligatorio.',
            'companyWeb.url' => 'El campo web de la compañía debe ser una URL válida.',
        ];
    }
}
