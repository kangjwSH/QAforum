<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Request;

class Answer extends Model
{
    //

    public function vote(){
        if(!user_ins()->is_logged_in()){
            return ['status'=>0,'msg'=>'login is required'];
        }

        if(!Request::get('id')||!Request::get('vote')){
            return ['status'=>0,'msg'=>'id and vote are required'];
        }
        $answer=$this->find(Request::get('id'));
        if(!$answer){
            return ['status'=>0,'msg'=>'answer does not exist'];
        }
        $vote=Request::get('vote')<=1?1:2;
        $answer->users()
            ->newPivotStatement()
            ->where('user_id',session('user_id'))
            ->where('answer_id',Request::get('id'))
            ->delete();
        $answer->users()
            ->attach(session('user_id'),['vote'=>$vote]);

        return ['status'=>1];
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function users(){
        return $this
            ->belongsToMany('App\User')
            ->withPivot('vote')
            ->withTimestamps();
    }
}
