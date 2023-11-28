<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
class QuizController extends Controller
{
    //

    public function index(Request $request)
    {
           // Check if the 'location' attribute is present in the request
           if ($request->has('location')) {
            // Retrieve quizzes based on the 'location' attribute
            $quizzes = Quiz::where('location', $request->input('location'))->get();
        } else {
            // If 'location' is not provided, retrieve all quizzes
            $quizzes = [];
        }

        return $quizzes;
    }

    public function show($id)
    {
        return Quiz::find($id);
    }

    public function store(Request $request)
    {
        return Quiz::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->update($request->all());

        return $quiz;
    }

    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();

        return 204;
    }



}
