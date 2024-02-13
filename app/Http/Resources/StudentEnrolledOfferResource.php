<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentEnrolledOfferResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'student_id' => $this->student_id,
            'job_offer_id' => $this->job_offer_id,
        ];
    }
}
