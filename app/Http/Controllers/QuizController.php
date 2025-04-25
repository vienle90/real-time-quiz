<?php

namespace App\Http\Controllers;

use App\Enums\QuizDifficulty;
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

    public function index(Request $request): JsonResponse
    {
        $difficulty = $request->query('difficulty');
        $featured = $request->boolean('featured');
        
        $quizzes = $this->quizService->getQuizzesByDifficulty($difficulty, $featured);
        
        return response()->json($quizzes);
    }
    
    /**
     * Get featured quizzes.
     *
     * @return JsonResponse
     */
    public function featured(): JsonResponse
    {
        $featuredQuizzes = $this->quizService->getFeaturedQuizzes();
        return response()->json($featuredQuizzes);
    }

    public function getDifficultyLevels(): JsonResponse
    {
        // Add "All" option
        $allOption = [
            'value' => 'all',
            'label' => 'All',
            'color' => 'primary',
        ];

        $levels = array_map(function ($value) {
            $enum = QuizDifficulty::from($value);
            return [
                'value' => $value,
                'label' => $enum->label(),
                'color' => $enum->color(),
            ];
        }, QuizDifficulty::values());

        // Prepend "All" option to the levels array
        array_unshift($levels, $allOption);

        return response()->json($levels);
    }

    public function show(int $quizId): JsonResponse
    {
        try {
            $quiz = $this->quizService->getQuizById($quizId);
            
            if (!$quiz) {
                return response()->json(['message' => 'Quiz not found'], 404);
            }
            
            return response()->json($quiz);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving quiz'], 500);
        }
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
