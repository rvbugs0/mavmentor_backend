<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionBank;
use App\Models\AnsweredQuestion;


class QuizPlayController extends Controller
{

    public function submitAnswer(Request $request)
    {
        // $request->validate([
        //     'user_id' => 'required|exists:users,id',
        //     'question_id' => 'required|exists:questions,id',
        //     'selected_answer' => 'required|integer|between:1,4', // Assuming selected_answer is an integer between 1 and 4
        // ]);

        if (!($request->has('user_id') && $request->has('question_id') && $request->has('selected_answer'))) {
            return response()->json(['success' => false, 'message' => 'Parameters missing'], 200);

        }

        // AnsweredQuestion::create([
        //     'user_id' => $request->user_id,
        //     'question_id' => $request->question_id,
        //     'selected_answer' => $request->selected_answer,
        // ]);
        try {
            AnsweredQuestion::firstOrCreate(
                [
                    'user_id' => $request->user_id,
                    'question_id' => $request->question_id,
                ],
                [
                    'selected_answer' => $request->selected_answer,
                ]
            );
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error processing the request'], 200);
        }

        return response()->json(['success' => true, 'message' => 'User answer recorded successfully'], 200);
    }
    //
    public function getUnansweredQuestions(Request $request)
    {
        if ($request->has('user_id') && $request->has('quiz_id')) {
    
            $userId = $request->input('user_id');
            $quizId = $request->input('quiz_id');
    
            // Get all questions for the specified quiz
            $quizQuestions = QuestionBank::where('quiz_id', $quizId)->get();
    
            // Get the IDs of questions that the user has already answered
            $answeredQuestionIds = AnsweredQuestion::where('user_id', $userId)
                ->whereIn('question_id', $quizQuestions->pluck('id'))
                ->pluck('question_id');
    
            // Filter out questions that the user has already answered
            $unansweredQuestions = $quizQuestions->reject(function ($question) use ($answeredQuestionIds) {
                return $answeredQuestionIds->contains($question->id);
            });
    
            return response()->json($unansweredQuestions);
    
        } else {
            return response()->json([]);
        }
    }

    public function getQuestionsByQuizId($quizId)
    {
        // Retrieve all questions for a specific quiz ID
        $questions = QuestionBank::where('quiz_id', $quizId)->get();

        return $questions;
    }

    public function calculateScore(Request $request)
    {
        if ($request->has('user_id') && $request->has('quiz_id')) {

            $userId = $request->input('user_id');
            $quizId = $request->input('quiz_id');
            $all_questions = $this->getQuestionsByQuizId($quizId);

            // to prevent divide by 0 error
            $total_questions = max($all_questions->count(), 0.00001);
            // Get all answered questions for the specified user

            $questionIds = $all_questions->pluck('id')->toArray();
            $answeredQuestions = AnsweredQuestion::where('user_id', $userId)->whereIn('question_id', $questionIds)->get();

            // Calculate the score based on correct and incorrect answers
            $score = $answeredQuestions->reduce(function ($carry, $answeredQuestion) {
                // If the selected answer is the correct answer, add 1 to the score
                if ($answeredQuestion->selected_answer === $answeredQuestion->question->answer) {
                    return $carry + 1;
                }
                // Otherwise, the answer is incorrect, so the score remains unchanged
                return $carry;
            }, 0);



            return response()->json(['success' => true, 'score' => ($score * 100 / $total_questions)]);

        } else {
            return response()->json(['success' => false, 'message' => 'USERID or QUIZ ID not provided']);
        }



    }

    public function resetQuiz(Request $request)
    {
        if ($request->has('user_id') && $request->has('quiz_id')) {

            $userId = $request->input('user_id');
            $quizId = $request->input('quiz_id');
        // Delete all answered questions for the specified user and quiz
        AnsweredQuestion::where('user_id', $userId)
            ->whereHas('question', function ($query) use ($quizId) {
                $query->where('quiz_id', $quizId);
            })
            ->delete();

        return response()->json(['success'=> true,'message' => 'Quiz reset successfully'], 200);

        }else{
            return response()->json(['success'=> false,'message' => 'Parameters missing'], 200);

        }


    }
}
