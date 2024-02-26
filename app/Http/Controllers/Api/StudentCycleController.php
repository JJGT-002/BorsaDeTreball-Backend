<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentCycleRequest;
use App\Http\Resources\DefaultCollection;
use App\Http\Resources\StudentCycleResource;
use App\Models\Cycle;
use App\Models\ResponsibleCycle;
use App\Models\StudentCycle;
use App\Models\User;
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

    public function getStudentsByResponsibleCycleId($responsibleId) {
        $cycleId = ResponsibleCycle::where('responsible_id', $responsibleId)->value('cycle_id');
        $cycle = Cycle::find($cycleId);

        $students = $cycle->student;

        return view('studentCycles.index', compact('students'));
    }

    public function getCyclesByStudentId($studentId): JsonResponse
    {
        try {
            $cycles = StudentCycle::where('student_id', $studentId)->get();
            $transformedData = $cycles->map(function ($studentCycle) {
                return [
                    'cycle_id' => $studentCycle->cycle_id,
                    'cliteral' => Cycle::where('id',$studentCycle->cycle_id)->first()->cliteral,
                    'endDate' => $studentCycle->endDate,
                ];
            });
            return response()->json([
                'message' => 'Student Cycles found',
                'data' => $transformedData,
            ], ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch student cycles',
                'message' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
