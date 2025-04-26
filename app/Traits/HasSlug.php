<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    public static function bootHasSlug()
    {
        static::creating(function (Model $model) {
            if (empty($model->slug)) {
                $model->slug = self::generateUniqueSlug($model);
            }
        });

        static::updating(function (Model $model) {
            // If the title (or source field for slug) has changed and slug wasn't manually set
            if ($model->isDirty($model->getSlugSourceField()) && !$model->isDirty('slug')) {
                $model->slug = self::generateUniqueSlug($model);
            }
        });
    }

    /**
     * Get the field to use as source for the slug.
     *
     * @return string
     */
    public function getSlugSourceField(): string
    {
        return $this->slugSourceField ?? 'title';
    }

    /**
     * Generate a unique slug for the model.
     *
     * @param Model $model
     * @return string
     */
    protected static function generateUniqueSlug(Model $model): string
    {
        $sourceField = $model->getSlugSourceField();
        $baseSlug = Str::slug($model->{$sourceField});
        $slug = $baseSlug;
        $counter = 1;

        // Check for existing slug
        while (static::where('slug', $slug)
            ->where('id', '!=', $model->id ?: 0)
            ->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Find a model by its slug.
     *
     * @param string $slug
     * @param array $columns
     * @return Model|null
     */
    public static function findBySlug(string $slug, array $columns = ['*'])
    {
        return static::where('slug', $slug)->first($columns);
    }
}
