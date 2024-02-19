<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Http\Resources\DefaultCollection;
use App\Http\Resources\StudentResource;
use App\Mail\ActivationEmail;
use App\Models\Student;
use App\Models\StudentCycle;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class StudentController extends Controller {

    public function index(): DefaultCollection {
        $students = Student::paginate(10);
        return new DefaultCollection($students);
    }

    public function store(StudentRequest $request): JsonResponse {
        try {
            DB::beginTransaction();
            $user = new User([
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'address' => $request['address'],
                'accept' => $request['accept'],
                'role' => 'student',
                'isActivated' => 0,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
            $user->save();

            $student = new Student([
                'user_id' => $user->id,
                'name' => $request['name'],
                'surnames' => $request['surnames'],
                'urlCV' => $request['urlCV'],
            ]);
            $student->save();

            if (isset($request['cycle_endDate_ids']) && is_array($request['cycle_endDate_ids'])) {
                foreach ($request['cycle_endDate_ids'] as $cycles) {
                    $student->cycle()->attach($cycles['cycle'],['endDate'=>$cycles['endDate']]);

                    StudentCycle::where([
                        'student_id' => $student->id,
                        'cycle_id' => $cycles['cycle']
                    ])->update(['created_at' => Carbon::now()]);
                }
            }

            Mail::to($user->email)->send(new ActivationEmail($user));

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

    public function update(StudentRequest $request, Student $student): JsonResponse {
        try {
            $student->update($request->all());
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

    private function addStatus($resource) {
        $data = $resource->toArray(request());
        $data['status'] = 'success';
        return $data;
    }
}
