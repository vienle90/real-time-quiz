<?php

namespace Tests\Unit\Services;


use App\Events\QuestionAnswerSubmitted;
use App\Models\QuestionChoice;
use App\Models\Quiz;
use App\Models\QuizUser;
use App\Repositories\Contracts\QuestionChoiceRepositoryInterface;
use App\Repositories\Contracts\QuizRepositoryInterface;
use App\Repositories\Contracts\QuizUserRepositoryInterface;
use App\Services\QuizService;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class QuizServiceTest extends TestCase
{
    private readonly QuizRepositoryInterface|MockObject $quizRepository;
    private readonly QuizUserRepositoryInterface|MockObject $quizUserRepository;
    private readonly QuestionChoiceRepositoryInterface|MockObject $questionChoiceRepository;

    private readonly QuizService $quizService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->quizRepository = $this->createMock(QuizRepositoryInterface::class);
        $this->quizUserRepository = $this->createMock(QuizUserRepositoryInterface::class);
        $this->questionChoiceRepository = $this->createMock(QuestionChoiceRepositoryInterface::class);

        $this->quizService = new QuizService(
            $this->quizRepository,
            $this->quizUserRepository,
            $this->questionChoiceRepository
        );
    }

    public function test_can_return_all_quizzes()
    {
        $quizzes = Quiz::factory()->count(2)->make();
        $this->quizRepository->expects($this->once())
            ->method('getQuizzes')
            ->willReturn($quizzes);

        $this->assertEquals($quizzes->toArray(), $this->quizService->getAllQuizzes()->toArray());
    }

    public function test_can_join_quiz()
    {
        $quizUser = QuizUser::factory()->make();
        $this->quizUserRepository->expects($this->once())
            ->method('joinQuiz')
            ->with(1, 1)
            ->willReturn($quizUser);

        $this->assertEquals($quizUser->toArray(), $this->quizService->joinQuiz(1, 1)->toArray());
    }

    public function test_can_return_user()
    {
        $quizUser = QuizUser::factory()->make();
        $this->quizUserRepository->expects($this->once())
            ->method('getUser')
            ->with(1, 1)
            ->willReturn($quizUser);

        $this->assertEquals($quizUser->toArray(), $this->quizService->getUser(1, 1)->toArray());
    }

    public function test_can_answer_correct_question()
    {
        Event::fake();
        $quizId = 1;
        $userId = 2;
        $questionId = 3;
        $choiceId = 4;

        $questionChoice = QuestionChoice::factory()->make([
            'question_id' => $questionId,
            'is_correct' => true,
        ]);


        $this->questionChoiceRepository->expects($this->once())
            ->method('findOrFail')
            ->with($choiceId, $questionId)
            ->willReturn($questionChoice);

        $result = $this->quizService->answerQuestion($quizId, $userId, $questionId, $choiceId);

        Event::assertDispatched(QuestionAnswerSubmitted::class, function (QuestionAnswerSubmitted $event) use ($questionId, $userId, $quizId, $choiceId, $questionChoice) {
            return $event->questionId === $questionId
                && $event->userId === $userId
                && $event->quizId === $quizId
                && $event->choiceId === $choiceId
                && $event->isCorrect === $questionChoice->is_correct
                && $event->score === QuizService::SCORE_INCREMENT;
        });

        $this->assertEquals([
            'is_correct' => true,
            'score' => QuizService::SCORE_INCREMENT,
            'choice_id' => $choiceId,
        ], $result);
    }

}
