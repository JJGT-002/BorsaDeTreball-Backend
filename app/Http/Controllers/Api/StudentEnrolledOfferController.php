<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentEnrolledOfferRequest;
use App\Http\Resources\DefaultCollection;
use App\Http\Resources\StudentEnrolledOfferResource;
use App\Models\StudentEnrolledOffer;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class StudentEnrolledOfferController extends Controller {

    public function index(): DefaultCollection {
        $studentEnrolledOffers = StudentEnrolledOffer::paginate(10);
        return new DefaultCollection($studentEnrolledOffers);
    }

    public function store(StudentEnrolledOfferRequest $request): JsonResponse {
        try {
            DB::beginTransaction();
            $studentEnrolledOffer = new StudentEnrolledOffer([
                'student_id' => $request['student_id'],
                'job_offer_id' => $request['job_offer_id'],
            ]);
            $studentEnrolledOffer->save();
            DB::commit();
            return response()->json([
                'message' => 'Student Enrolled Offer created successfully',
                'data' => new StudentEnrolledOfferResource($studentEnrolledOffer)
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to create student enrolled offer',
                'message' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(StudentEnrolledOffer $studentEnrolledOffer) {
        $studentEnrolledOfferResource = new StudentEnrolledOfferResource($studentEnrolledOffer);
        return $this->addStatus($studentEnrolledOfferResource);
    }

    public function update(StudentEnrolledOfferRequest $request, StudentEnrolledOffer $studentEnrolledOffer): JsonResponse
    {
        try {
            $studentEnrolledOffer->update($request->all());
            return response()->json([
                'message' => 'Student Enrolled Offer updated successfully',
                'data' => new StudentEnrolledOfferResource($studentEnrolledOffer)
            ], ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to update student enrolled offer',
                'message' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(StudentEnrolledOffer $studentEnrolledOffer): JsonResponse {
        try {
            $studentEnrolledOffer->delete();
            return response()->json([
                'message' => 'Student Enrolled Offer deleted successfully',
                'data' => $studentEnrolledOffer->id
            ]);
        } catch (Exception) {
            return response()->json([
                'error' => 'Student Enrolled Offer not found'
            ], 404);
        }
    }

    private function addStatus($resource) {
        $data = $resource->toArray(request());
        $data['status'] = 'success';
        return $data;
    }
}
