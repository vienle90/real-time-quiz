<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    /**
     * Get all categories.
     *
     * @return Collection<int, Category>
     */
    public function getAllCategories(): Collection;

    /**
     * Find category by ID.
     *
     * @param int $id
     * @param array $relations Relationships to eager load
     * @return Category|null
     */
    public function findById(int $id, array $relations = []): ?Category;

    /**
     * Get quizzes by category ID.
     *
     * @param int $categoryId
     * @return Collection
     */
    public function getQuizzesByCategoryId(int $categoryId): Collection;
}