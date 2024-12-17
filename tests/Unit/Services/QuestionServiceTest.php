<?php

namespace Tests\Unit\Services;

use App\Models\Question;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use App\Services\QuestionService;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class QuestionServiceTest extends TestCase
{
    private readonly QuestionRepositoryInterface|MockObject $questionRepository;
    private readonly QuestionService $questionService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->questionRepository = $this->createMock(QuestionRepositoryInterface::class);
        $this->questionService = new QuestionService($this->questionRepository);
    }

    public function test_can_return_questions()
    {
        $questions = Question::factory()->count(2)->make([
            'quiz_id' => 1,
        ]);
        $this->questionRepository->expects($this->once())
            ->method('getQuestions')
            ->with(quizId: 1)
            ->willReturn($questions);

        $this->assertEquals($questions->toArray(), $this->questionService->getQuestions(1)->toArray());
    }
}
