<?php

namespace App\Observers;

use App\Models\Answer;
use App\Notifications\AnswerPosted;

class AnswerObserver
{
    /**
     * Handle the Answer "created" event.
     */
    public function created(Answer $answer): void
    {
        $questionOwner = $answer->question->user;
        $questionOwner->notify(new AnswerPosted($answer));
    }

    /**
     * Handle the Answer "updated" event.
     */
    public function updated(Answer $answer): void
    {
        //
    }

    /**
     * Handle the Answer "deleted" event.
     */
    public function deleted(Answer $answer): void
    {
        //
    }

    /**
     * Handle the Answer "restored" event.
     */
    public function restored(Answer $answer): void
    {
        //
    }

    /**
     * Handle the Answer "force deleted" event.
     */
    public function forceDeleted(Answer $answer): void
    {
        //
    }
}
