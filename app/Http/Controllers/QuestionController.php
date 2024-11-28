<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        return view('questions', [
            'questions' => Question::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
        ]);

        $question = new Question();
        $question->question = $request->question;
        $question->save();

        return redirect()->route('questions.index');
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question' => 'required|string|max:255',
        ]);

        $question->question = $request->question;
        $question->save();

        return redirect()->route('questions.index');
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('questions.index');
    }
}
