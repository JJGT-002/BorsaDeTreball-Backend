<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource {

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'cif' => $this->cif,
            'contactName' => $this->contactName,
            'companyWeb' => $this->companyWeb,
            'email' => $this->User->email,
            'address' => $this->User->address,
        ];
    }
}
