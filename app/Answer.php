<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Request;

class Answer extends Model
{
    //
    public function add(){
        if(!user_ins()->is_logged_in()){
            return ['status'=>0,'msg'=>'login is required'];
        }
        if(!Request::get('question_id')||!Request::get('content')){
            return ['status'=>0,'msg'=>'question_id and content are required'];
        }
        $question=question_ins()->find(Request::get('question_id'));
        if(!$question){
            return ['status'=>0,'msg'=>'question does not exist'];
        }

        $answered=$this
            ->where(['question_id'=>Request::get('question_id'),'user_id'=>session('user_id')])
            ->count();

        if($answered){
            return ['status'=>0,'msg'=>'duplicate answer'];
        }

        $this->question_id=Request::get('question_id');
        $this->content=Request::get('content');
        $this->user_id=session('user_id');

        return $this->save()?
            ['status'=>1,'id'=>$this->id]:
            ['status'=>0,'msg'=>'db insert failed'];
    }

    public function change(){
        if(!user_ins()->is_logged_in()){
            return ['status'=>0,'msg'=>'login is required'];
        }
        if(!Request::get('id')||!Request::get('content')){
            return ['status'=>0,'msg'=>'id and content is required'];
        }

        $answer=$this->find(Request::get('id'));
        if($answer->user_id!=session('user_id')){
            return ['status'=>0,'msg'=>'permission denied'];
        }

        $answer->content=Request::get('content');
        return $answer->save()?
            ['status'=>1]:
            ['status'=>0,'msg'=>'db update failed'];
    }

    public function read(){
        if(!Request::get('id')&&!Request::get('question_id')){
            return ['status'=>0,'msg'=>'id or question_id are required'];
        }
        if(Request::get('id')){
            $answer=$this->find(Request::get('id'));
            if(!$answer){
                return ['status'=>0,'msg'=>'answer does not exist'];
            }
            return ['status'=>1,'data'=>$answer];
        }

        if(!question_ins()->find(Request::get('question_id'))){
            return ['status'=>0,'msg'=>'question does not exist'];
        }

        $answers=$this->where('question_id',Request::get('question_id'))->get()->keyBy('id');
        return ['status'=>1,'data'=>$answers];
    }
}
