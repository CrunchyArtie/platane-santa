<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Question::with('users')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        throw new \Exception('Not implemented');
    }

    public function storeResponse(Request $request, Question $question)
    {

        $request->validate([
            'response' => 'required|string|max:255',
        ]);

        $user = $request->user();

        // find the question already attached to the user and update the response
        $question->users()->syncWithoutDetaching([$user->id => ['response' => $request->response]]);

        return response()->json(['question' => $question->load('users')], 201);
    }

    public function updateResponse(Request $request, Question $question)
    {
        $request->validate([
            'response' => 'required|string|max:255',
        ]);

        $question->users()->updateExistingPivot($request->user()->id, ['response' => $request->response]);

        return response()->json(['question' => $question->load('users')], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        throw new \Exception('Not implemented');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        throw new \Exception('Not implemented');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        throw new \Exception('Not implemented');
    }
}
