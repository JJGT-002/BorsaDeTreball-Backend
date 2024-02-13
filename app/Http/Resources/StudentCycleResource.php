<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentCycleResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'cycle_id' => $this->cycle_id,
            'student_id' => $this->student_id,
            'endDate' => $this->endDate,
            'isValid' => $this->isValid,
        ];
    }
}
