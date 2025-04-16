<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/users', 'App\Http\Controllers\UserController@create');
Route::get('/quizzes', 'App\Http\Controllers\QuizController@index');
Route::get('/quizzes/{quizId}', 'App\Http\Controllers\QuizController@show');
Route::get('/quizzes/{quizId}/leaderboard', 'App\Http\Controllers\QuizController@leaderboard');
Route::post('/quizzes/{quizId}/users', 'App\Http\Controllers\QuizController@joinQuiz');
Route::get('/quizzes/{quizId}/users/{userId}', 'App\Http\Controllers\QuizController@getUser');
Route::get('/quizzes/{quizId}/questions', 'App\Http\Controllers\QuizController@getQuestions');
Route::post('/quizzes/{quizId}/questions/{questionId}/answers', 'App\Http\Controllers\QuizController@answerQuestion');
