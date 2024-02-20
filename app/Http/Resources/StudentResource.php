<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource {

    public function toArray($request) {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'surnames' => $this->surnames,
            'urlCV' => $this->urlCV,
            'isActivated' => $this->isActivated,
            'email' => $this->User->email,
            'address' => $this->User->address,
        ];
    }
}
