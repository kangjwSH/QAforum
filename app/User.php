<?php

namespace App;

use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Model;
use Request;
use Hash;

class User extends Model
{
    //

    public function answers(){
        return $this
            ->belongsToMany('App\Answer')
            ->withPivot('vote')
            ->withTimestamps();
    }


}
