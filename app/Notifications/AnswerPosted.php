<?php

namespace App\Notifications;

use App\Models\Answer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AnswerPosted extends Notification
{
    use Queueable;

    protected $answer;
    /**
     * Create a new notification instance.
     */
    public function __construct(Answer $answer)
    {
         $this->answer = $answer; 
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [ 'database'];
    }

 
    public function toDatabase($notifiable){

        return[
            'message'=>' answered your question',
            'question_id' => $this->answer->question_id,
            'question_slug' => $this->answer->question->slug,
            'answer_id' =>  $this->answer->id,
            'user_name' =>  $this->answer->user->name,
        ];
    }

    
}
