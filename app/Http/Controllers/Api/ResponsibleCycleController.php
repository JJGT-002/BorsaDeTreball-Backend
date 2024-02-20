<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResponsibleCycleRequest;
use App\Http\Resources\DefaultCollection;
use App\Http\Resources\ResponsibleCycleResource;
use App\Models\ResponsibleCycle;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ResponsibleCycleController extends Controller {

    public function index(): DefaultCollection {
        $responsibleCycles = ResponsibleCycle::paginate(10);
        return new DefaultCollection($responsibleCycles);
    }

    public function store(ResponsibleCycleRequest $request): JsonResponse {
        try {
            DB::beginTransaction();
            $responsibleCycle = new ResponsibleCycle([
                'responsible_id' => $request['responsible_id'],
                'cycle_id' => $request['cycle_id'],
            ]);
            $responsibleCycle->save();
            DB::commit();
            return response()->json([
                'message' => 'Responsible Cycle created successfully',
                'data' => new ResponsibleCycleResource($responsibleCycle)
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to create responsible cycle',
                'message' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
