<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CycleResource extends JsonResource
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
            'departamento' => $this->departamento,
            'tipo' => $this->tipo,
            'normativa' => $this->normativa,
            'titol' => $this->titol,
            'rd' => $this->rd,
            'rd2' => $this->rd2,
            'vliteral' => $this->vliteral,
            'cliteral' => $this->cliteral,
            'horasFct' => $this->horasFct,
            'acronim' => $this->acronim,
            'llocTreball' => $this->llocTreball,
            'dataSignaturaDual' => $this->dataSignaturaDual,
        ];
    }
}
