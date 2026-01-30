<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Http\Requests\UpdateAnswerRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Notifications\AnswerPosted;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AnswerController extends Controller
{

    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnswerRequest $request)
    {
        $answer=$request->user()->answers()->create($request->validated());
        $question = Question::findOrFail($request->question_id);
        $question->increment('answer_count');
        return back()->with('message','Answer submitted successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnswerRequest $request, Answer $answer)
    {
        if(!$this->authorize('update', $answer)){
            abort(403);
        }

    

        $answer->update($request->validated());

        return back()->with('message','Answer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Answer $answer)
{       
        if(!$this->authorize('delete', $answer)){
            abort(403);
        }

        $answer->delete();
        $question = Question::findOrFail($answer->question_id);
        $question->decrement('answer_count');
        return back()->with('message','Answer deleted successfully');
    }
}
