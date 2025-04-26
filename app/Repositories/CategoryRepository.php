<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getAllCategories(): Collection
    {
        return Category::all();
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id, array $relations = []): ?Category
    {
        return Category::with($relations)->find($id);
    }

    /**
     * @inheritDoc
     */
    public function getQuizzesByCategoryId(int $categoryId): Collection
    {
        $category = Category::findOrFail($categoryId);
        return $category->quizzes()->with('category')->get();
    }
}