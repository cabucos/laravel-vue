<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title','body'];

    public function setTitleAttribute($value){

        $this->attributes['title']  = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute(){

        return route('question.show', $this->slug);
    }

    public function getCreatedDateAttribute(){

        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute(){

        if($this->answers_count > 0){
            if($this->best_answer_id){
                return "answer-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }

    public function answers(){

        return $this->hasMany(Answer::class);
   }

   public function acceptBestAnswer(Answer $answer){

       $this->best_answer_id = $answer->id;
       $this->save();
   }
}
