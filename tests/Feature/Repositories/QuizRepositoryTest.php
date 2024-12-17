<?php

namespace Tests\Feature\Repositories;

use App\Models\Quiz;
use App\Repositories\QuizRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuizRepositoryTest extends TestCase
{
    use RefreshDatabase;
    private readonly QuizRepository $quizRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->quizRepository = new QuizRepository();
    }

    public function test_can_get_quizzes()
    {
        Quiz::factory()->count(2)->create();
        $quizzes = $this->quizRepository->getQuizzes();
        $this->assertDatabaseCount('quizzes', 2);
        $this->assertCount(2, $quizzes);
    }
}
