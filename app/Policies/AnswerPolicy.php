<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AnswerPolicy
{
   

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Answer $answer)
    {
        if($user->id==$answer->user->id){
            return true;
           }
           return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Answer $answer): bool
    {
        if($user->id==$answer->user->id){
            return true;
           }
           return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Answer $answer): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Answer $answer): bool
    {
        return false;
    }
}
