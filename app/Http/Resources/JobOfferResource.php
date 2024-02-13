<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobOfferResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'company_id' => $this->company_id,
            'observations' => $this->observations,
            'description' => $this->description,
            'contractDuration' => $this->contractDuration,
            'contact' => $this->contact,
            'registrationMethod' => $this->registrationMethod,
            'isActive' => $this->isActive,
            'isDeleted' => $this->isDeleted,
            'isValid' => $this->isValid,
        ];
    }
}
