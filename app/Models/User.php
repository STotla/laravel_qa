<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable ;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['avatar_url'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }
    public function favourites(){
        return $this->belongsToMany(Question::class,'favourites')->withTimestamps();
    }

    public function voteQuestions(){
        return $this->morphedByMany(Question::class,'votable')->withTimestamps();
    }
    public function voteAnswers(){
        return $this->morphedByMany(Answer::class,'votable')->withTimestamps();
    }
    public function voteQuestion(Question $question, int $vote){
        $voteQuestions= $this->voteQuestions();
        if($voteQuestions->where('votable_id',$question->id)->exists()){
            $voteQuestions->updateExistingPivot($question, ['vote'=>$vote]);
        }else{
        $voteQuestions->attach($question,['vote'=>$vote]);
        }

        $question->load('votes');
        $upVotes= $question->upVotes()->sum('vote');
        $downVotes= $question->downVotes()->sum('vote');
        $question->votes_count= $upVotes + $downVotes;
        $question->save();
    }

    public function hasVotedQuestion(Question $question): bool{
        return $this->voteQuestions()->where('votable_id',$question->id)->exists();
    }
    public function getQuestionVoteValue(Question $question) {
        $votable = $this->voteQuestions()->
        select('vote')->
        where('votable_id', $question->id)->first();
        return $votable->vote??0;
    }

    //  Answer vote methods

    public function voteAnswer(Answer $answer, int $vote){

        $voteAnswers= $this->voteAnswers();
        if($voteAnswers->where('votable_id',$answer->id)->exists()){
            $voteAnswers->updateExistingPivot($answer, ['vote'=>$vote]);
        }else{
        $voteAnswers->attach($answer,['vote'=>$vote]);
        }

        $answer->load('votes');
        $upVotes= $answer->upVotes()->sum('vote');
        $downVotes= $answer->downVotes()->sum('vote');
        $answer->votes_count= $upVotes + $downVotes;
        $answer->save();
    }
    public function hasVotedAnswer(Answer $answer): bool{
        return $this->voteAnswers()->where('votable_id',$answer->id)->exists();
    }
    public function getAnswerVoteValue(Answer $answer) {
        $votable = $this->voteAnswers()->
        select('vote')->
        where('votable_id', $answer->id)->first();
        return $votable->vote??0;
    }
    
    public function getAvatarUrlAttribute()
    {
            if (!$this->avatar_path) {
                return "https://ui-avatars.com/api/?name=" . $this->name . "&background=random";
            }

            return Storage::disk('public')->url($this->avatar_path);
        
    }
}