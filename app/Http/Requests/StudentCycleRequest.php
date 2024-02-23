<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentCycleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $studentCycleId = $this->route('studentCycles') ? $this->route('studentCycles')->id : null;

        return [
            'cycle_id' => [
                'required',
                Rule::unique('student_cycles')->where(function ($query) {
                    return $query->where('student_id', $this->student_id);
                })->ignore($studentCycleId),
            ],
            'student_id' => [
                'required',
                Rule::unique('student_cycles')->where(function ($query) {
                    return $query->where('cycle_id', $this->cycle_id);
                })->ignore($studentCycleId),
            ],
            'endDate' => 'nullable|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'cycle_id.required' => 'El campo ciclo id es obligatorio.',
            'student_id.required' => 'El campo estudiante id es obligatorio.',
            'cycle_id.unique' => 'Ya existe un ciclo con este estudiante.',
            'student_id.unique' => 'Este estudiante ya tiene asignado este ciclo.',
            'endDate.numeric' => 'El campo de fecha de finalización del ciclo debe ser numérico.',
        ];
    }
}
