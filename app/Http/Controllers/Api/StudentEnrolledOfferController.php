<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentEnrolledOfferRequest;
use App\Http\Resources\StudentEnrolledOfferCollection;
use App\Http\Resources\StudentEnrolledOfferResource;
use App\Models\StudentEnrolledOffer;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class StudentEnrolledOfferController extends Controller
{

    public function index(): StudentEnrolledOfferCollection
    {
        $studentEnrolledOffers = StudentEnrolledOffer::paginate(10);
        return new StudentEnrolledOfferCollection($studentEnrolledOffers);
    }

    public function store(StudentEnrolledOfferRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            DB::beginTransaction();
            $studentEnrolledOffer = new StudentEnrolledOffer([
                'student_id' => $validatedData['student_id'],
                'job_offer_id' => $validatedData['job_offer_id'],
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

    public function show(StudentEnrolledOffer $studentEnrolledOffer)
    {
        $studentEnrolledOfferResource = new StudentEnrolledOfferResource($studentEnrolledOffer);
        return $this->addStatus($studentEnrolledOfferResource);
    }

    public function update(StudentEnrolledOfferRequest $request, StudentEnrolledOffer $studentEnrolledOffer)
    {
        try {
            $validatedData = $request->validated();

            $studentEnrolledOffer->student_id = $validatedData['student_id'];
            $studentEnrolledOffer->job_offer_id = $validatedData['job_offer_id'];

            $studentEnrolledOffer->save();

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

    public function destroy(StudentEnrolledOffer $studentEnrolledOffer): JsonResponse
    {
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
