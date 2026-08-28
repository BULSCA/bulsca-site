<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompetitionResource;
use App\Interfaces\CompetitionRepositoryInterface;
use App\Traits\ApiResponseTrait;

class CompetitionApiController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private CompetitionRepositoryInterface $competitionRepository
    ) {
    }

    public function index()
    {
        try {
            $competitions = $this->competitionRepository->index();
            return $this->successResponse(
                CompetitionResource::collection($competitions),
                'Competitions retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve competitions', 500);
        }
    }

    public function show($id)
    {
        try {
            $competition = $this->competitionRepository->getById($id);
            return $this->successResponse(
                new CompetitionResource($competition),
                'Competition retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Competition not found', 404);
        }
    }
}
