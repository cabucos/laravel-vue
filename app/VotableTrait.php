<?php

namespace App;

trait VotableTrait
{
    public function upVotes(){

        return $this->votes()->wherePivot('vote', 1);
    }

    public function downVotes(){

        return $this->votes()->wherePivot('vote', -1);
    }
}
