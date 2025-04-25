<?php

namespace Database\Seeders;

use App\Enums\QuizDifficulty;
use App\Models\Quiz;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('quizzes')->truncate();
        
        $quizzes = [
            [
                'title' => 'Web Development Fundamentals',
                'description' => 'Test your knowledge of HTML, CSS, and JavaScript basics.',
                'difficulty' => QuizDifficulty::EASY->value,
            ],
            [
                'title' => 'PHP Programming Concepts',
                'description' => 'Challenge yourself with intermediate PHP concepts and techniques.',
                'difficulty' => QuizDifficulty::MEDIUM->value,
            ],
            [
                'title' => 'Advanced Laravel Development',
                'description' => 'Test your expertise with advanced Laravel concepts and best practices.',
                'difficulty' => QuizDifficulty::HARD->value,
            ],
            [
                'title' => 'SQL Basics',
                'description' => 'Test your knowledge of SQL fundamentals and simple queries.',
                'difficulty' => QuizDifficulty::EASY->value,
            ],
            [
                'title' => 'Vue.js Component Architecture',
                'description' => 'Challenge yourself with component design patterns and state management.',
                'difficulty' => QuizDifficulty::MEDIUM->value,
            ],
            [
                'title' => 'System Design and Architecture',
                'description' => 'Advanced concepts in designing scalable and maintainable systems.',
                'difficulty' => QuizDifficulty::HARD->value,
            ],
        ];

        foreach ($quizzes as $quiz) {
            Quiz::create($quiz);
        }
    }
}
