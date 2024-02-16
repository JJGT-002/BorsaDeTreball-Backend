<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DefaultCollection;
use App\Http\Resources\ProfessionalFamilyResource;
use App\Models\ProfessionalFamily;

class ProfessionalFamilyController extends Controller {

    public function index(): DefaultCollection {
        $professionalFamilies = ProfessionalFamily::paginate(10);
        return new DefaultCollection($professionalFamilies);
    }

    public function show(ProfessionalFamily $professionalFamily) {
        $professionalFamilyResource = new ProfessionalFamilyResource($professionalFamily);
        return $this->addStatus($professionalFamilyResource);
    }

    private function addStatus($resource) {
        $data = $resource->toArray(request());
        $data['status'] = 'success';
        return $data;
    }
}
