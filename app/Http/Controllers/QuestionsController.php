<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionStoreRequest;
use App\Http\Requests\QuestionUpdateRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{

    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $questions = Question::with('user', 'answers')->latest()->paginate(10);
        return inertia('Questions/Index', [
            'questions' => QuestionResource::collection($questions),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Questions/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionStoreRequest $request)
    {
        $request->user()->questions()->create($request->validated());
        return redirect()->route('questions.index', ['message' => 'Question submitted successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        $question->load('answers');
        $question->increment('views');
        
        return Inertia::render('Questions/Show', [
            'question' => QuestionResource::make($question)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        if (!$this->authorize('edit', $question)) {
            abort('403');
        }
        $question->load('answers');
        return Inertia::render('Questions/Edit', [
            'question' => QuestionResource::make($question),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionUpdateRequest $request, Question $question)
    {

        if (!$this->authorize('update', $question)) {
            abort('403');
        }
        $question->update($request->validated());

        return redirect()->route('questions.index', [
            'message' => 'Question updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        if (!$this->authorize('destroy', $question)) {
            abort('403');
        }
        $question->delete();

        return redirect()->route('questions.index', ['message' => 'Question has been deleted successfully']);
    }

    public function search(Request $request){
        $searchText= '%'.$request->input('q').'%';

        $questions= Question::where('title','LIKE', $searchText)->get(['id','slug','title']);
        return response()->json($questions);

    }

    public function updateBestAnswer(Request $request, Question $question)
    {
        if (!$this->authorize('update', $question)) {
            abort('403');
        }
        // also check if the answer belongs to the question

        if (!$question->answers()->where('id', $request->best_answer_id)->exists()) {
            return back()->withErrors(['best_answer_id' => 'The selected answer does not belong to this question.']);
        }

        $validated = $request->validate([
            'best_answer_id' => 'required|integer|exists:answers,id',
        ]);

        $question->update(['best_answer_id' => $validated['best_answer_id']]);

        // check wheter question updated  or not
        return back()->with('message', 'Best answer updated successfully');
    }

    public function updateFavoriteStatusofQuestion(Request $request){

        $question= Question::find($request->id);
        if($request->make_favorite){
            $question->favourites()->attach(Auth::id());
            return back()->with('message', 'Marked as favorite');
        }else{
            $question->favourites()->detach(Auth::id());
            return back()->with('message', 'Removed from favorite');
        }


    }
}
