<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizUser extends Model
{
    /** @use HasFactory<\Database\Factories\QuizUserFactory> */
    use HasFactory;

    const STATUS_JOINED = 'joined';
    const STATUS_COMPLETED = 'completed';
    const STATUS_IN_PROGRESS = 'in_progress';

    public $table = 'quizzes_users';

    protected $fillable = [
        'quiz_id',
        'user_id',
        'score',
        'status'
    ];
}
