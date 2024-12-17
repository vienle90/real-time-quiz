<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Repositories\QuestionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionRepositoryTest extends TestCase
{
    use RefreshDatabase;
    private readonly QuestionRepository $questionRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->questionRepository = new QuestionRepository();
    }

    public function test_can_get_questions()
    {
        Question::factory([
            'quiz_id' => 1,
        ])->count(2)->create();
        $questions = $this->questionRepository->getQuestions(1);
        $this->assertDatabaseCount('questions', 2);
        $this->assertCount(2, $questions);
    }

    public function test_can_find_question()
    {
        $question = Question::factory([
            'quiz_id' => 1,
        ])->create();
        $foundQuestion = $this->questionRepository->findOrFail($question->id);
        $this->assertEquals($question->id, $foundQuestion->id);
    }

    public function test_cannot_find_question()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->questionRepository->findOrFail(11);
    }
}
