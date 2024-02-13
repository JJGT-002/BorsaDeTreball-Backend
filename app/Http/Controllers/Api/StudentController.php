<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class StudentController extends Controller {

    public function index(): StudentCollection
    {
        $students = Student::paginate(10);
        return new StudentCollection($students);
    }

    public function store(StudentRequest $request): JsonResponse {
        try {
            $validatedData = $request->validated();
            DB::beginTransaction();
            $user = new User([
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'address' => $validatedData['address'],
                'role' => 'student',
            ]);
            $user->save();

            $student = new Student([
                'user_id' => $user->id,
                'name' => $validatedData['name'],
                'surnames' => $validatedData['surnames'],
                'urlCV' => $validatedData['urlCV'],
            ]);
            $student->save();
            DB::commit();
            return response()->json([
                'message' => 'Student created successfully',
                'data' => new StudentResource($student)
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to create student',
                'message' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Student $student) {
        $studentResource = new StudentResource($student);
        return $this->addStatus($studentResource);
    }

    public function update(StudentRequest $request, Student $student): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $student->name = $validatedData['name'];
            $student->surnames = $validatedData['surnames'];
            $student->urlCV = $validatedData['urlCV'];

            $student->save();

            $user = $student->user();

            $user->update([
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'address' => $validatedData['address'],
                'accept' => $validatedData['accept'] ?? false,
                'observations' => $validatedData['observations'] ?? 'Sin observaciones',
                'isDeleted' => $validatedData['isDeleted'] ?? false,
            ]);

            return response()->json([
                'message' => 'Student updated successfully',
                'data' => new StudentResource($student)
            ], ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to update student',
                'message' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Student $student): JsonResponse
    {
        try {
            $student->delete();
            return response()->json([
                'message' => 'Student deleted successfully',
                'data' => $student->id
            ]);
        } catch (Exception) {
            return response()->json([
                'error' => 'Student not found'
            ], 404);
        }
    }

    private function addStatus($resource) {
        $data = $resource->toArray(request());
        $data['status'] = 'success';
        return $data;
    }
}
