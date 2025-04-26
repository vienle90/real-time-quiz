<?php

namespace App\Models;

use App\Enums\QuizDifficulty;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    /** 
     * @use HasFactory<\Database\Factories\QuizFactory>
     * @use HasSlug
     */
    use HasFactory, HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'difficulty',
        'is_featured',
        'slug',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'difficulty' => QuizDifficulty::class,
        'is_featured' => 'boolean',
    ];

    /**
     * Convert the model instance to an array.
     *
     * @return array<string, mixed>
     */
    public function toArray()
    {
        $array = parent::toArray();

        if ($this->difficulty) {
            $array['difficulty'] = [
                'value' => $this->difficulty->value,
                'label' => $this->difficulty->label(),
                'color' => $this->difficulty->color(),
            ];
        }

        if ($this->relationLoaded('category')) {
            $array['category'] = $this->category;
        }

        return $array;
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'quiz_id');
    }

    /**
     * Get the category that owns the quiz.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
