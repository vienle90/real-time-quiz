<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Get all categories.
     */
    public function index(): JsonResponse
    {
        $categories = Category::all();
        
        return response()->json($categories);
    }

    /**
     * Get quizzes by category.
     */
    public function quizzes(int $categoryId): JsonResponse
    {
        $category = Category::findOrFail($categoryId);
        $quizzes = $category->quizzes()->with('category')->get();
        
        return response()->json($quizzes);
    }
}