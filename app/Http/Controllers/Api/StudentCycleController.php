<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentCycleRequest;
use App\Http\Resources\StudentCycleCollection;
use App\Http\Resources\StudentCycleResource;
use App\Models\StudentCycle;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class StudentCycleController extends Controller
{

    public function index(): StudentCycleCollection
    {
        $studentCycle = StudentCycle::paginate(10);
        return new StudentCycleCollection($studentCycle);
    }

    public function store(StudentCycleRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            DB::beginTransaction();
            $studentCycle = new StudentCycle([
                'cycle_id' => $validatedData['cycle_id'],
                'student_id' => $validatedData['student_id'],
                'endDate' => $validatedData['endDate'],
                'isValid' => $validatedData['isValid'],
            ]);
            $studentCycle->save();
            DB::commit();
            return response()->json([
                'message' => 'Student Cycle created successfully',
                'data' => new StudentCycleResource($studentCycle)
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to create student cycle',
                'message' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(StudentCycle $studentCycle)
    {
        $studentCycleResource = new StudentCycleResource($studentCycle);
        return $this->addStatus($studentCycleResource);
    }

    public function update(StudentCycleRequest $request, StudentCycle $studentCycle)
    {
        try {
            $validatedData = $request->validated();

            $studentCycle->cycle_id = $validatedData['cycle_id'];
            $studentCycle->student_id = $validatedData['student_id'];
            $studentCycle->endDate = $validatedData['endDate'];
            $studentCycle->isValid = $validatedData['isValid'];

            $studentCycle->save();

            return response()->json([
                'message' => 'Student Cycle updated successfully',
                'data' => new StudentCycleResource($studentCycle)
            ], ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to update student cycle',
                'message' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(StudentCycle $studentCycle): JsonResponse
    {
        try {
            $studentCycle->delete();
            return response()->json([
                'message' => 'Student Cycle deleted successfully',
                'data' => $studentCycle->id
            ]);
        } catch (Exception) {
            return response()->json([
                'error' => 'Student Cycle not found'
            ], 404);
        }
    }

    private function addStatus($resource) {
        $data = $resource->toArray(request());
        $data['status'] = 'success';
        return $data;
    }
}
