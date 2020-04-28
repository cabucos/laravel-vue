<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title','body'];

    public function setTitleAttributes($value)
    {
        return $this->attributes['title']  = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
