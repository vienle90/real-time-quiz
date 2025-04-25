<?php

namespace App\Models;

use App\Enums\QuizDifficulty;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    /** @use HasFactory<\Database\Factories\QuizFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'difficulty',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'difficulty' => QuizDifficulty::class,
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
        
        return $array;
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'quiz_id');
    }
}
