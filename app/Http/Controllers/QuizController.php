<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Services\LeaderboardService;
use App\Services\QuestionService;
use App\Services\QuizService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function __construct(
        private readonly LeaderboardService $getTopUsersService,
        private readonly QuizService        $quizService,
        private readonly QuestionService    $questionService,
    )
    {
    }

    public function index(): JsonResponse
    {
        return response()->json($this->quizService->getAllQuizzes());
    }

    public function joinQuiz(Request $request, int $quizId): JsonResponse
    {
        $quizUser = $this->quizService->joinQuiz($quizId, $request->get('user_id'));
        return response()->json($quizUser, 201);
    }

    public function getUser(int $quizId, int $userId): JsonResponse
    {
        try {
            $quizUser = $this->quizService->getUser($quizId, $userId);
            return response()->json($quizUser);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User has not joined this quiz'], 404);
        }
    }

    public function getQuestions(int $quizId): JsonResponse
    {
        $questions = $this->questionService->getQuestions($quizId);
        return response()->json($questions);
    }

    public function answerQuestion(Request $request, int $quizId, int $questionId): JsonResponse
    {
        $userId = $request->get('user_id');
        $choiceId = $request->get('choice_id');
        $result = $this->quizService->answerQuestion($quizId, $userId, $questionId, $choiceId);
        return response()->json($result, 201);
    }

    public function leaderboard(string $quizId): JsonResponse
    {
        $topUsers = $this->getTopUsersService->__invoke($quizId);
        return response()->json($topUsers);
    }
}
