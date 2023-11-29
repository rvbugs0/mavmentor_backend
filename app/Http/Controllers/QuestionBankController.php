<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionBank;


class QuestionBankController extends Controller
{
    public function index()
    {
        return QuestionBank::all();
    }

    

    public function show($id)
    {
        return QuestionBank::find($id);
    }

    public function store(Request $request)
    {
        return QuestionBank::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $questionBank = QuestionBank::findOrFail($id);
        $questionBank->update($request->all());

        return $questionBank;
    }

    public function destroy($id)
    {
        $questionBank = QuestionBank::findOrFail($id);
        $questionBank->delete();

        return 204;
    }

}
