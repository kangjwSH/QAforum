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
            return ['status'=>0,'msg'=>'question_id or answer_id is required'];
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

    public function read(){
        if(!Request::get('question_id')&&!Request::get('answer_id')){
            return ['status'=>0,'msg'=>'question_id or answer_id is required'];
        }
        if(Request::get('question_id')){
            $question=question_ins()->find(Request::get('question_id'));
            if(!$question){
                return ['status'=>0,'msg'=>'question does not exist'];
            }
            $data=$this->where('question_id',Request::get('question_id'))->get()->keyBy('id');
        }else if(Request::get('answer_id')){
            $answer=answer_ins()->find(Request::get('answer_id'));
            if(!$answer){
                return ['status'=>0,'msg'=>'answer does not exist'];
            }
            $data=$this->where('answer_id',Request::get('answer_id'))->get()->keyBy('id');
        }
        return ['status'=>1,'data'=>$data];
    }

    public function remove(){
        if(!user_ins()->is_logged_in()){
            return ['status'=>0,'msg'=>'login is required'];
        }

        if(!Request::get('id')){
            return ['status'=>0,'msg'=>'id is required'];
        }

        $comment=$this->find(Request::get('id'));
        if(!$comment){
            return ['status'=>0,'msg'=>'comment does not exist'];
        }
        if($comment->user_id!=session('user_id')) {
            return ['status' => 0, 'msg' => 'permission denied'];
        }

        $this->where('reply_to',Request::get('id'))->delete();
        return $comment->delete()?
            ['status'=>1]:
            ['status'=>0,'msg'=>'db delete failed'];
    }
}
