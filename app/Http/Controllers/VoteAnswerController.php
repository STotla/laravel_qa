<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller; 

class VoteAnswerController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Answer $answer )
    {
        $vote = request()->vote;
        auth()->user()->voteAnswer($answer, $vote);
        if($vote == 1){
            return back()->with('success','You have upvoted the answer successfully.');
        }else{
            return back()->with('success','You have downvoted the answer successfully.');
        }
    }
}
