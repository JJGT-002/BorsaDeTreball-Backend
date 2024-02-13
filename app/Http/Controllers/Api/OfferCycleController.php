<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfferCycleRequest;
use App\Http\Resources\OfferCycleCollection;
use App\Http\Resources\OfferCycleResource;
use App\Models\OfferCycle;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class OfferCycleController extends Controller
{

    public function index(): OfferCycleCollection
    {
        $offers = OfferCycle::paginate(10);
        return new OfferCycleCollection($offers);
    }

    public function store(OfferCycleRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            DB::beginTransaction();
            $offerCycle = new OfferCycle([
                'job_offer_id' => $validatedData['job_offer_id'],
                'cycle_id' => $validatedData['cycle_id'],
            ]);
            $offerCycle->save();
            DB::commit();
            return response()->json([
                'message' => 'Offer Cycle created successfully',
                'data' => new OfferCycleResource($offerCycle)
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to create offer cycle',
                'message' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(OfferCycle $offerCycle)
    {
        $offerCycleResource = new OfferCycleResource($offerCycle);
        return $this->addStatus($offerCycleResource);
    }

    public function update(OfferCycleRequest $request, OfferCycle $offerCycle): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $offerCycle->job_offer_id = $validatedData['job_offer_id'];
            $offerCycle->cycle_id = $validatedData['cycle_id'];

            $offerCycle->save();

            return response()->json([
                'message' => 'Offer Cycle updated successfully',
                'data' => new OfferCycleResource($offerCycle)
            ], ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to update cycle',
                'message' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(OfferCycle $offerCycle): JsonResponse
    {
        try {
            $offerCycle->delete();
            return response()->json([
                'message' => 'Offer Cycle deleted successfully',
                'data' => $offerCycle->id
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
