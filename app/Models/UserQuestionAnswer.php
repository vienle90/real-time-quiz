<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuestionAnswer extends Model
{
    /** @use HasFactory<\Database\Factories\UserQuestionAnswerFactory> */
    use HasFactory;

    public $table = 'user_question_answers';

    protected $fillable = [
        'user_id',
        'question_id',
        'choice_id',
        'is_correct',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
