<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository
    )
    {
    }

    /**
     * Get all categories.
     *
     * @return Collection
     */
    public function getAllCategories(): Collection
    {
        return $this->categoryRepository->getAllCategories();
    }

    /**
     * Get quizzes by category ID.
     *
     * @param int $categoryId
     * @return Collection
     */
    public function getQuizzesByCategoryId(int $categoryId): Collection
    {
        return $this->categoryRepository->getQuizzesByCategoryId($categoryId);
    }

    /**
     * Find category by ID.
     *
     * @param int $id
     * @param array $relations
     * @return Category|null
     */
    public function findById(int $id, array $relations = []): ?Category
    {
        return $this->categoryRepository->findById($id, $relations);
    }
}