<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobOfferRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'company_id' => 'nullable|exists:companies,id',
                'observations' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:255',
                'contractDuration' => 'nullable|string',
                'contact' => 'nullable|string|max:50',
                'registrationMethod' => 'nullable|in:email,atTheMoment',
                'isActive' => 'nullable|boolean',
                'isDeleted' => 'nullable|boolean',
                'isValid' => 'nullable|boolean',
            ];
        }
        return [
            'company_id' => 'required|exists:companies,id',
            'observations' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'contractDuration' => 'required|string',
            'contact' => 'required|string|max:50',
            'registrationMethod' => 'required|in:email,atTheMoment',
        ];
    }

    public function messages(): array {
        return [
            'company_id.required' => 'El ID de la empresa es obligatorio.',
            'company_id.exists' => 'El ID de la empresa no existe en la base de datos.',
            'observations.required' => 'Las observaciones son obligatorias.',
            'observations.max' => 'Las observaciones no deben tener más de :max caracteres.',
            'description.required' => 'La descripción es obligatoria.',
            'description.max' => 'La descripción no debe tener más de :max caracteres.',
            'contractDuration.required' => 'La duración del contrato es obligatoria.',
            'contact.required' => 'El contacto es obligatorio.',
            'contact.max' => 'El contacto no debe tener más de :max caracteres.',
            'registrationMethod.required' => 'El método de registro es obligatorio.',
            'registrationMethod.in' => 'El método de registro seleccionado no es válido.',
            'isActive.required' => 'El campo isActive es obligatorio.',
            'isActive.boolean' => 'El campo isActive debe ser verdadero o falso.',
            'isDeleted.required' => 'El campo isDeleted es obligatorio.',
            'isDeleted.boolean' => 'El campo isDeleted debe ser verdadero o falso.',
            'isValid.required' => 'El campo isValid es obligatorio.',
            'isValid.boolean' => 'El campo isValid debe ser verdadero o falso.',
        ];
    }
}
