<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferCycleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'job_offer_id' => $this->job_offer_id,
            'cycle_id' => $this->cycle_id,
        ];
    }
}
