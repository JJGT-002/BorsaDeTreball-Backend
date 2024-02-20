<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResponsibleCycleRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {

        return [
            'responsible_id' => [
                'required',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', 'responsible');
                }),
            ],
            'cycle_id' => [
                'required',
                Rule::exists('cycles', 'id'),
            ],
        ];
    }

    public function messages(): array {
        return [
            'responsible_id.required' => 'El campo responsible_id es obligatorio.',
            'cycle_id.required' => 'El campo cycle_id es obligatorio.',
            'responsible_id.exists' => 'El usuario seleccionado no existe o no es un responsable.',
            'cycle_id.exists' => 'El ciclo seleccionado no existe.',
        ];
    }
}
