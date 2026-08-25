<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Interfaces\ArticleRepositoryInterface;
use App\Traits\ApiResponseTrait;

class ArticleApiController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private ArticleRepositoryInterface $articleRepository
    ) {
    }

    public function index()
    {
        try {
            $articles = $this->articleRepository->index();
            return $this->successResponse(
                ArticleResource::collection($articles),
                'Articles retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve articles', 500);
        }
    }

    public function show($id)
    {
        try {
            $article = $this->articleRepository->getById($id);
            return $this->successResponse(
                new ArticleResource($article),
                'Article retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Article not found', 404);
        }
    }
}
