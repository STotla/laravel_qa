<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class QuestionPolicy
{
   

    public function edit(User $user, Question $question): bool
    {
       if($user->id==$question->user->id){
        return true;
       }
       return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Question $question): bool
    {
       if($user->id==$question->user->id){
        return true;
       }
       return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Question $question): bool
    {
       if($user->id==$question->user->id){
        return true;
       }
       return false;
    }

   
}
