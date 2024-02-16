<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobOfferRequest;
use App\Http\Resources\DefaultCollection;
use App\Http\Resources\JobOfferResource;
use App\Models\JobOffer;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class JobOfferController extends Controller {

    public function index(): DefaultCollection {
        $jobOffers = JobOffer::paginate(10);
        return new DefaultCollection($jobOffers);
    }

    public function store(JobOfferRequest $request): JsonResponse {
        try {
            DB::beginTransaction();
            $jobOffer = new JobOffer([
                'company_id' => $request['company_id'],
                'observations' => $request['observations'],
                'description' => $request['description'],
                'contractDuration' => $request['contractDuration'],
                'contact' => $request['contact'],
                'registrationMethod' => $request['registrationMethod'],
            ]);
            $jobOffer->save();
            DB::commit();
            return response()->json([
                'message' => 'Job Offer created successfully',
                'data' => new JobOfferResource($jobOffer)
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to create job offer',
                'message' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(JobOffer $jobOffer) {
        $jobOfferResource = new JobOfferResource($jobOffer);
        return $this->addStatus($jobOfferResource);
    }

    public function update(JobOfferRequest $request, JobOffer $jobOffer): JsonResponse {
        try {
            $jobOffer->update($request->all());
            return response()->json([
                'message' => 'Job Offer updated successfully',
                'data' => new JobOfferResource($jobOffer)
            ], ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to update job offer',
                'message' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(JobOffer $jobOffer): JsonResponse {
        try {
            $jobOffer->delete();
            return response()->json([
                'message' => 'Job Offer deleted successfully',
                'data' => $jobOffer->id
            ]);
        } catch (Exception) {
            return response()->json([
                'error' => 'Job Offer not found'
            ], 404);
        }
    }

    private function addStatus($resource) {
        $data = $resource->toArray(request());
        $data['status'] = 'success';
        return $data;
    }
}
