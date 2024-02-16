<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CycleResource;
use App\Http\Resources\DefaultCollection;
use App\Models\Cycle;

class CycleController extends Controller {

    public function index(): DefaultCollection {
        $cycles = Cycle::paginate(10);
        return new DefaultCollection($cycles);
    }

    public function show(Cycle $cycle) {
        $cycleResource = new CycleResource($cycle);
        return $this->addStatus($cycleResource);
    }

    private function addStatus($resource) {
        $data = $resource->toArray(request());
        $data['status'] = 'success';
        return $data;
    }
}
