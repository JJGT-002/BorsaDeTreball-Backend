<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentEnrolledOfferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $studentEnrolledOffer = $this->route('studentEnrolledOffers') ? $this->route('studentEnrolledOffers')->id : null;

        return [
            'student_id' => [
                'required',
                Rule::unique('student_enrolled_offers')->where(function ($query) {
                    return $query->where('job_offer_id', $this->job_offer_id);
                })->ignore($studentEnrolledOffer),
            ],
            'job_offer_id' => [
                'required',
                Rule::unique('student_enrolled_offers')->where(function ($query) {
                    return $query->where('student_id', $this->student_id);
                })->ignore($studentEnrolledOffer),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required' => 'El campo student id es obligatorio.',
            'job_offer_id.required' => 'El campo jobOffer id es obligatorio.',
            'student_id.unique' => 'Ya existe un estudiante con este id.',
            'job_offer_id.unique' => 'Esta oferta de trabajo ya existe.',
        ];
    }
}
