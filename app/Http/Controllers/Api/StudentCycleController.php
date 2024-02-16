<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentCycleRequest;
use App\Http\Resources\DefaultCollection;
use App\Http\Resources\StudentCycleResource;
use App\Models\StudentCycle;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class StudentCycleController extends Controller {

    public function index(): DefaultCollection {
        $studentCycle = StudentCycle::paginate(10);
        return new DefaultCollection($studentCycle);
    }

    public function store(StudentCycleRequest $request): JsonResponse {
        try {
            DB::beginTransaction();
            $studentCycle = new StudentCycle([
                'cycle_id' => $request['cycle_id'],
                'student_id' => $request['student_id'],
                'endDate' => $request['endDate'],
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

    public function update(StudentCycleRequest $request, StudentCycle $studentCycle): JsonResponse {
        try {
            $studentCycle->update($request->all());
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
}
