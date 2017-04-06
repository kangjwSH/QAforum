<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Request;

class Comment extends Model
{
    //

    public function add(){
        if(!user_ins()->is_logged_in()){
            return ['status'=>0,'msg'=>'login is required'];
        }

        if(!Request::get('content')){
            return ['status'=>0,'msg'=>'content is required'];
        }

        if(
            (!Request::get('question_id')&&!Request::get('answer_id'))||
            (Request::get('question_id')&&Request::get('answer_id'))
        ){
            return ['status'=>0,'msg'=>'question_id or answer_id are required'];
        }

        if(Request::get('question_id')){
            $question=question_ins()->find(Request::get('question_id'));
            if(!$question){
                return ['status'=>0,'msg'=>'question does not exist'];
            }
            $this->question_id=Request::get('question_id');
        }else if(Request::get('answer_id')){
            $answer=answer_ins()->find(Request::get('answer_id'));
            if(!$answer){
                return ['status'=>0,'msg'=>'answer does not exist'];
            }
            $this->answer_id=Request::get('answer_id');
        };

        if(Request::get('reply_to')){
            $target=$this->find(Request::get('reply_to'));
            if(!$target){
                return ['status'=>0,'msg'=>'target comment does not exist'];
            }
            if($target->user_id==session('user_id')){
                return ['status'=>0,'msg'=>'cannot reply to yourself'];
            }
            $this->reply_to=Request::get('reply_to');
        }

        $this->content=Request::get('content');
        $this->user_id=session('user_id');
        return $this->save()?
            ['status'=>1,'id'=>$this->id]:
            ['status'=>0,'msg'=>'db insert failed'];
    }
}
