<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $answerStatus = 'not-answered';
        if ($this->answer_count > 0) {

            if ($this->best_answer_id) {
                $answerStatus = 'answer-accepted';
            } else {
                $answerStatus = 'answer-submitted';
            }
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'created_date' => $this->created_at->diffForHumans(),
            'user' => $this->user,
            'votes_count' => $this->votes_count,
            'views' => $this->views,
            'answer_count' => $this->answer_count,
            'answer_status' => $answerStatus,
            'best_answer_id' => $this->best_answer_id,
            'slug' => $this->slug,
            'is_favourited' => $this->isFavourited(),
            'favourites_count' => $this->favourites()->count(),
            'can' => [
                'update' => $request->user() ? $request->user()->can('update', $this->resource) : false,
                'destroy' => $request->user() ? $request->user()->can('delete', $this->resource) : false,
            ],

            'is_voted' => $request->user() ? $request->user()->hasVotedQuestion($this->resource) : false,
            'vote_value' => $request->user() ? $request->user()->getQuestionVoteValue($this->resource) : 0,

            'votes' => $this->votes(),
            'answers' => AnswerResource::collection($this->whenLoaded('answers')->sortByDesc(function ($answer) {
                return $answer->id === $this->best_answer_id ? 1 : 0;
            })->values()),

        ];
    }
}
