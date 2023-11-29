<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionBankController;
use App\Http\Controllers\QuizPlayController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('users', UserController::class);
Route::resource('roles', RoleController::class);
Route::resource('locations', LocationController::class);
Route::resource('quizzes', QuizController::class);
Route::resource('question_banks', QuestionBankController::class);
Route::get('/quiz-play/{userId}/{quizId}/unanswered-questions', [QuizPlayController::class, 'getUnansweredQuestions']);
Route::get('/quiz-play/{userId}/calculate-score', [QuizPlayController::class, 'calculateScore']);
Route::delete('/quiz-play/{userId}/{quizId}/reset-quiz', [QuizPlayController::class, 'resetQuiz']);
Route::post('/user-exists', [UserController::class, 'generatePassword']);

Route::post('/authenticate', [UserController::class, 'authenticate']);
Route::get('/check-user-exists', [UserController::class, 'checkUserExists']);

Route::get('/get-quiz-score', [QuizPlayController::class, 'calculateScore']);

Route::get('/get-questions', [QuizPlayController::class, 'getUnansweredQuestions']);

