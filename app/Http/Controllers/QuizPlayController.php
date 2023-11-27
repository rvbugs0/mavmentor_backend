<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionBank;
use App\Models\AnsweredQuestion;


class QuizPlayController extends Controller
{

    public function submitAnswer(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'question_id' => 'required|exists:questions,id',
            'selected_answer' => 'required|integer|between:1,4', // Assuming selected_answer is an integer between 1 and 4
        ]);

        AnsweredQuestion::create([
            'user_id' => $request->user_id,
            'question_id' => $request->question_id,
            'selected_answer' => $request->selected_answer,
        ]);

        return response()->json(['message' => 'User answer recorded successfully'], 201);
    }
    //
    public function getUnansweredQuestions($userId, $quizId)
    {
        // Get all questions for the specified quiz
        $quizQuestions = QuestionBank::where('quiz_id', $quizId)->get();

        // Get the IDs of questions that the user has already answered
        $answeredQuestionIds = AnsweredQuestion::where('user_id', $userId)
            ->where('question_id', $quizQuestions->pluck('id')->toArray())
            ->pluck('question_id');

        // Filter out questions that the user has already answered
        $unansweredQuestions = $quizQuestions->reject(function ($question) use ($answeredQuestionIds) {
            return in_array($question->id, $answeredQuestionIds->toArray());
        });

        return $unansweredQuestions;
    }

    public function calculateScore($userId)
    {
        // Get all answered questions for the specified user
        $answeredQuestions = AnsweredQuestion::where('user_id', $userId)->get();

        // Calculate the score based on correct and incorrect answers
        $score = $answeredQuestions->reduce(function ($carry, $answeredQuestion) {
            // If the selected answer is the correct answer, add 1 to the score
            if ($answeredQuestion->selected_answer === $answeredQuestion->question->answer) {
                return $carry + 1;
            }
            // Otherwise, the answer is incorrect, so the score remains unchanged
            return $carry;
        }, 0);

        return ['score' => $score];
    }

    public function resetQuiz($userId, $quizId)
    {
        // Delete all answered questions for the specified user and quiz
        AnsweredQuestion::where('user_id', $userId)
            ->whereHas('question', function ($query) use ($quizId) {
                $query->where('quiz_id', $quizId);
            })
            ->delete();

        return response()->json(['message' => 'Quiz reset successfully'], 200);
    }
}
