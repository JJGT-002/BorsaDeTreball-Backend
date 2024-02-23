<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CycleResource;
use App\Http\Resources\DefaultCollection;
use App\Models\Cycle;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

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

    public function getAllCycles(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $cycles = Cycle::all();
        return view('cycles.index', compact('cycles'));
    }

    public function getCyclesByResponsibleUserId($userId) {
        // Obtener el usuario responsable
        $user = User::findOrFail($userId);

        // Obtener los ciclos asociados al usuario responsable
        $cycles = $user->cycles;

        return view('cycles.index', compact('cycles'));
    }
}
