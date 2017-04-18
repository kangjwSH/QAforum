<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Request;

class Question extends Model
{
    //
    public function user(){
        return $this->belongsTo('App\User');
    }
}
