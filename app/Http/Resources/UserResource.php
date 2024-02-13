<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {

    public function toArray($request) {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'password' => $this->password,
            'address' => $this->address,
            'accept' => $this->accept,
            'observations' => $this->observations,
            'role' => $this->role,
            'isDeleted' => $this->isDeleted,
        ];
    }
}
