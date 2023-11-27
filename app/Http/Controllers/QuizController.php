<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
class QuizController extends Controller
{
    //

    public function index()
    {
        return Quiz::all();
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
