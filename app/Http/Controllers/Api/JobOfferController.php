<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobOfferRequest;
use App\Http\Resources\JobOfferCollection;
use App\Http\Resources\JobOfferResource;
use App\Models\JobOffer;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class JobOfferController extends Controller
{

    public function index(): JobOfferCollection
    {
        $jobOffers = JobOffer::paginate(10);
        return new JobOfferCollection($jobOffers);
    }

    public function store(JobOfferRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            DB::beginTransaction();
            $jobOffer = new Cycle([
                'departamento' => $validatedData['departamento'],
                'tipo' => $validatedData['tipo'],
                'normativa' => $validatedData['normativa'],
                'titol' => $validatedData['titol'],
                'rd' => $validatedData['rd'],
                'rd2' => $validatedData['rd2'],
                'vliteral' => $validatedData['vliteral'],
                'cliteral' => $validatedData['cliteral'],
                'horasFct' => $validatedData['horasFct'],
                'acronim' => $validatedData['acronim'],
                'llocTreball' => $validatedData['llocTreball'],
                'dataSignatura' => $validatedData['dataSignatura'],
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

    public function show(JobOffer $jobOffer)
    {
        $jobOfferResource = new JobOfferResource($jobOffer);
        return $this->addStatus($jobOfferResource);
    }

    public function update(JobOfferRequest $request, JobOffer $jobOffer): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $cycle->departamento = $validatedData['departamento'];
            $cycle->tipo = $validatedData['tipo'];
            $cycle->normativa = $validatedData['normativa'];
            $cycle->titol = $validatedData['titol'];
            $cycle->rd = $validatedData['rd'];
            $cycle->rd2 = $validatedData['rd2'];
            $cycle->vliteral = $validatedData['vliteral'];
            $cycle->cliteral = $validatedData['cliteral'];
            $cycle->horasFct = $validatedData['horasFct'];
            $cycle->acronim = $validatedData['acronim'];
            $cycle->llocTreball = $validatedData['llocTreball'];
            $cycle->dataSignatura = $validatedData['dataSignatura'];

            $cycle->save();

            return response()->json([
                'message' => 'Cycle updated successfully',
                'data' => new CycleResource($cycle)
            ], ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to update cycle',
                'message' => $e->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(JobOffer $jobOffer): JsonResponse
    {
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
