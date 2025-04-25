<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class QuestionChoice extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionChoiceFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question_id',
        'choice',
        'is_correct',
    ];

    protected $hidden = ['is_correct', 'question_id', 'created_at', 'updated_at'];

    protected function casts(): array
    {
        return [
            'is_correct' => 'boolean',
        ];
    }
}
