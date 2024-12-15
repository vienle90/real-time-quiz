<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'api'], function () {
    Route::get('/quiz/{quizId}/leaderboard', 'App\Http\Controllers\QuizController@leaderboard');
});
