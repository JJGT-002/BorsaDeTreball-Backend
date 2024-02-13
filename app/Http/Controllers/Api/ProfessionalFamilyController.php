<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfessionalFamilyRequest;
use App\Http\Resources\ProfessionalFamilyCollection;
use App\Http\Resources\ProfessionalFamilyResource;
use App\Models\ProfessionalFamily;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProfessionalFamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ProfessionalFamilyCollection
    {
        $professionalFamilies = ProfessionalFamily::paginate(10);
        return new ProfessionalFamilyCollection($professionalFamilies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfessionalFamilyRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            DB::beginTransaction();
            $professionalFamily = new ProfessionalFamily([
                'cliteral' => $validatedData['cliteral'],
                'vliteral' => $validatedData['vliteral'],
                'depcurt' => $validatedData['depcurt'],
                'didactico' => $validatedData['didactico'],
            ]);
            $professionalFamily->save();
            DB::commit();
            return response()->json([
                'message' => 'Student created successfully',
                'data' => new ProfessionalFamilyResource($professionalFamily)
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to create student',
                'message' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProfessionalFamily $professionalFamily)
    {
        $professionalFamilyResource = new ProfessionalFamilyResource($professionalFamily);
        return $this->addStatus($professionalFamilyResource);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProfessionalFamily $professionalFamily): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $professionalFamily->name = $validatedData['name'];
            $professionalFamily->surnames = $validatedData['surnames'];
            $professionalFamily->urlCV = $validatedData['urlCV'];

            $professionalFamily->save();

            return response()->json([
                'message' => 'Professional Family updated successfully',
                'data' => new ProfessionalFamilyResource($professionalFamily)
            ], ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to update Professional Family',
                'message' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProfessionalFamily $professionalFamily): JsonResponse
    {
        try {
            $professionalFamily->delete();
            return response()->json([
                'message' => 'Professional Family deleted successfully',
                'data' => $professionalFamily->id
            ]);
        } catch (Exception) {
            return response()->json([
                'error' => 'Professional Family not found'
            ], 404);
        }
    }

    private function addStatus($resource) {
        $data = $resource->toArray(request());
        $data['status'] = 'success';
        return $data;
    }
}
