<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory;
    protected  $fillable=['title','body','best_answer_id'];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function setTitleAttribute($value){
        $this->attributes['title']=$value;
        $this->attributes['slug']= Str::slug($value);
    
    }
    

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function favourites(){
        return $this->belongsToMany(User::class,'favourites')->withTimestamps();
    }
    
    public function isFavourited(){
        return $this->favourites()->where('user_id',auth()->id())->count()>0;
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
