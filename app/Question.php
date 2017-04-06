<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Request;

class Question extends Model
{
    //
    public function add(){
        if(!user_ins()->is_logged_in()){
            return ['status'=>0,'msg'=>'login is required'];
        }
        if(!Request::get('title')){
            return ['status'=>0,'msg'=>'title is required'];
        }
        $this->title=Request::get('title');
        $this->user_id=session('user_id');
        if(Request::get('desc')){
            $this->desc=Request::get('desc');
        }
        return $this->save()?
            ['status'=>1,'id'=>$this->id]:
            ['status'=>0,'msg'=>'db insert failed'];
    }

    public function change(){
        if(!user_ins()->is_logged_in()){
            return ['status'=>0,'msg'=>'login is required'];
        }
        if(!Request::get('id')){
            return ['status'=>0,'msg'=>'id is required'];
        }
        $question=$this->find(Request::get('id'));
        if(!$question){
            return ['status'=>0,'msg'=>'question does not exist'];
        }
        if($question->user_id!=session('user_id')){
            return ['status'=>0,'msg'=>'permission denied'];
        }
        if(Request::get('title')){
            $question->title=Request::get('title');
        }
        if(Request::get('desc')){
            $question->desc=Request::get('desc');
        }

        return $question->save()?
            ['status'=>1]:
            ['status'=>0,'msg'=>'db update failed'];
    }

    public function read(){
        if(Request::get('id')){
            return ['status'=>1,'data'=>$this->find(Request::get('id'))];
        }

        $limit=Request::get('limit')?:15;
        $skip=((Request::get('page')?:1)-1)*$limit;
        $data=$this->orderBy('created_at')
            ->limit($limit)
            ->skip($skip)
            ->get(['id','title','desc','created_at','updated_at'])
            ->keyBy('id');
        return ['status'=>1,'data'=>$data];
    }

    public function remove(){
        if(!user_ins()->is_logged_in()){
            return ['status'=>0,'msg'=>'login is required'];
        }
        if(!Request::get('id')){
            return ['status'=>0,'msg'=>'id is required'];
        }
        $question=$this->find(Request::get('id'));
        if(!$question){
            return ['status'=>0,'msg'=>'question does not exist'];
        }
        if($question->user_id!=session('user_id')) {
            return ['status' => 0, 'msg' => 'permission denied'];
        }
        return $question->delete()?
            ['status'=>1]:
            ['status'=>0,'msg'=>'db delete failed'];
    }
}
