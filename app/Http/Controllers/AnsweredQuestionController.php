<?php

namespace App\Http\Controllers;
use App\Models\AnsweredQuestion;
use Illuminate\Http\Request;

class AnsweredQuestionController extends Controller
{
    //
    public function index()
    {
        return AnsweredQuestion::all();
    }

    public function show($id)
    {
        return AnsweredQuestion::find($id);
    }

    public function store(Request $request)
    {
        return AnsweredQuestion::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $answeredQuestion = AnsweredQuestion::findOrFail($id);
        $answeredQuestion->update($request->all());

        return $answeredQuestion;
    }

    public function destroy($id)
    {
        $answeredQuestion = AnsweredQuestion::findOrFail($id);
        $answeredQuestion->delete();

        return 204;
    }
}
