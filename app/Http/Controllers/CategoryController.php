<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService,
    )
    {
    }

    /**
     * Get all categories.
     */
    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAllCategories();

        return response()->json($categories);
    }

    /**
     * Get quizzes by category.
     */
    public function quizzes(int $categoryId): JsonResponse
    {
        $quizzes = $this->categoryService->getQuizzesByCategoryId($categoryId);

        return response()->json($quizzes);
    }
}
