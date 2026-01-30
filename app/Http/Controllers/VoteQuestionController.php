<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller; // Add this line

class VoteQuestionController extends Controller
{
    /**
     * Handle the incoming request.
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function __invoke(Question $question)
    {
        $vote = (int) request()->vote;
        auth()->user()->voteQuestion($question, $vote);
        if($vote === 1){
            return back()->with('message', 'You have upvoted the question successfully.');
        }elseif($vote === -1){
            return back()->with('message', 'You have downvoted the question successfully.');
        }
    }
}
