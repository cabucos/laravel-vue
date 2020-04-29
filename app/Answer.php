<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function question(){

        return $this->belongsTo(Question::class);
    }

    public function user(){

        return $this->belonsTo(User::class);
    }

    public static function boot(){

        parent::boot();

        static::created(function($answer){
            $answer->question->increment('answer_count');
            $answer->question->save();
        });

        static::saved(function($answer){
            echo "Answer saved";
        });
    }
}
