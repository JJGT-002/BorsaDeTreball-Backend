<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfessionalFamilyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cliteral' => $this->cliteral,
            'vliteral' => $this->vliteral,
            'depcurt' => $this->depcurt,
            'didactico' => $this->didactico,
        ];
    }
}
