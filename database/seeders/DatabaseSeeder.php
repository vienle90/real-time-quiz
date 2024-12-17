<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('quizzes')->truncate();
        DB::table('questions')->truncate();
        DB::table('question_choices')->truncate();

        Quiz::factory()
            ->count(10)
            ->has(Question::factory(20))
            ->create();

        $questions = Question::all();
        foreach ($questions as $question) {
            $question->choices()->createMany([
                ['choice' => 'Choice 1', 'is_correct' => false],
                ['choice' => 'Choice 2', 'is_correct' => false],
                ['choice' => 'Choice 3', 'is_correct' => false],
                ['choice' => 'Choice 4', 'is_correct' => true],
            ]);
        }
    }
}
