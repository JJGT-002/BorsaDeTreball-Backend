<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CycleRequest;
use App\Http\Resources\CycleCollection;
use App\Http\Resources\CycleResource;
use App\Models\Cycle;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CycleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): CycleCollection
    {
        $cycles = Cycle::paginate(10);
        return new CycleCollection($cycles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CycleRequest $request)
    {
        try {
            $validatedData = $request->validated();
            DB::beginTransaction();
            $cycle = new Cycle([
                'departamento' => $validatedData['departamento'],
                'tipo' => $validatedData['tipo'],
                'normativa' => $validatedData['normativa'],
                'titol' => $validatedData['titol'],
                'rd' => $validatedData['rd'],
                'rd2' => $validatedData['rd2'],
                'vliteral' => $validatedData['vliteral'],
                'cliteral' => $validatedData['cliteral'],
                'horasFct' => $validatedData['horasFct'],
                'acronim' => $validatedData['acronim'],
                'llocTreball' => $validatedData['llocTreball'],
                'dataSignatura' => $validatedData['dataSignatura'],
            ]);
            $cycle->save();
            DB::commit();
            return response()->json([
                'message' => 'Cycle created successfully',
                'data' => new CycleResource($cycle)
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to create cycle',
                'message' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cycle $cycle)
    {
        $cycleResource = new CycleResource($cycle);
        return $this->addStatus($cycleResource);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CycleRequest $request, Cycle $cycle)
    {
        try {
            $validatedData = $request->validated();

            $cycle->departamento = $validatedData['departamento'];
            $cycle->tipo = $validatedData['tipo'];
            $cycle->normativa = $validatedData['normativa'];
            $cycle->titol = $validatedData['titol'];
            $cycle->rd = $validatedData['rd'];
            $cycle->rd2 = $validatedData['rd2'];
            $cycle->vliteral = $validatedData['vliteral'];
            $cycle->cliteral = $validatedData['cliteral'];
            $cycle->horasFct = $validatedData['horasFct'];
            $cycle->acronim = $validatedData['acronim'];
            $cycle->llocTreball = $validatedData['llocTreball'];
            $cycle->dataSignatura = $validatedData['dataSignatura'];

            $cycle->save();

            return response()->json([
                'message' => 'Cycle updated successfully',
                'data' => new CycleResource($cycle)
            ], ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to update cycle',
                'message' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cycle $cycle)
    {
        try {
            $cycle->delete();
            return response()->json([
                'message' => 'Cycle deleted successfully',
                'data' => $cycle->id
            ]);
        } catch (Exception) {
            return response()->json([
                'error' => 'Cycle not found'
            ], 404);
        }
    }

    private function addStatus($resource) {
        $data = $resource->toArray(request());
        $data['status'] = 'success';
        return $data;
    }
}
