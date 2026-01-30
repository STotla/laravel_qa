<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /** @use HasFactory<\Database\Factories\AnswerFactory> */
    use HasFactory;

    protected $fillable=[
        'body',
        'question_id',
    ];
    public function question(){
        $question= $this->belongsTo(Question::class);
        return $question;
    }

    public function user(){
        $user= $this->belongsTo(User::class);
        return $user;
    }
    public function votes(){
        return $this->morphToMany(User::class,'votable');
    }
    
    public function upVotes(){
        return $this->votes()->wherePivot('vote',1);
    }
    public function downVotes(){
        return $this->votes()->wherePivot('vote',-1);
    }
}
