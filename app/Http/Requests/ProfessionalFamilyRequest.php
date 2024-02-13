<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfessionalFamilyRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cliteral' => 'required|string|max:255',
            'vliteral' => 'required|string|max:255',
            'depcurt' => 'required|string|min:3',
            'didactico' => 'required|boolean'
        ];
    }

    public function messages() {
        return [
            'cliteral.required' => 'El campo cliteral es obligatorio.',
            'cliteral.string' => 'El campo cliteral debe ser una cadena de caracteres.',
            'cliteral.max' => 'El campo cliteral no puede ser mayor que :max caracteres.',
            'vliteral.required' => 'El campo vliteral es obligatorio.',
            'vliteral.string' => 'El campo vliteral debe ser una cadena de caracteres.',
            'vliteral.max' => 'El campo vliteral no puede ser mayor que :max caracteres.',
            'didactico.required' => 'El campo web de la didactico es obligatorio.',
            'didactico.boolean' => 'El campo web de la didactico debe ser un valor falso o verdadero (booleano).',
        ];
    }
}
