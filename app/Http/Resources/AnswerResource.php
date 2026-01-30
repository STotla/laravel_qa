<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'body'=>$this->body,
            'user'=>$this->user,
            'votes_count'=>$this->votes_count,
            'created_date'=>$this->created_at->diffForHumans(),
            'can'=>[
                'update'=>$request->user()?->can('update',$this->resource)??false,
                'delete'=>$request->user()?->can('delete',$this->resource)??false,
            ],
            'is_voted'=>$request->user() ? $request->user()->hasVotedAnswer($this->resource) : false,
            'vote_value'=>$request->user() ? $request->user()->getAnswerVoteValue($this->resource) : 0,
        ];
    }
}
