<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuestionController extends Controller
{
    //
    public function add(Request $request){
        if(!is_logged_in()){
            return ['status'=>0,'msg'=>'login is required'];
        }
        $title=$request->get('title');
        $desc=$request->get('desc');
        if(!$title){
            return ['status'=>0,'msg'=>'title is required'];
        }
        $question=question_ins();
        $question->title=$title;
        $question->user_id=session('user_id');
        if($desc){
            $question->desc=$desc;
        }
        return $question->save()?
            ['status'=>1,'id'=>$question->id]:
            ['status'=>0,'msg'=>'db insert failed'];
    }

    public function change(Request $request){
        if(!is_logged_in()){
            return ['status'=>0,'msg'=>'login is required'];
        }

        $id=$request->get('id');
        $title=$request->get('title');
        $desc=$request->get('desc');
        if(!$id){
            return ['status'=>0,'msg'=>'id is required'];
        }
        $question=question_ins()
            ->find($id);
        if(!$question){
            return ['status'=>0,'msg'=>'question does not exist'];
        }
        if($question->user_id!=session('user_id')){
            return ['status'=>0,'msg'=>'permission denied'];
        }
        if($title){
            $question->title=$title;
        }
        if($desc){
            $question->desc=$desc;
        }

        return $question->save()?
            ['status'=>1]:
            ['status'=>0,'msg'=>'db update failed'];
    }

    public function remove(Request $request){
        if(!is_logged_in()){
            return ['status'=>0,'msg'=>'login is required'];
        }
        $id=$request->get('id');
        if(!$id){
            return ['status'=>0,'msg'=>'id is required'];
        }
        $question=question_ins()
            ->find($id);
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

    public function read(Request $request){
        $id=$request->get('id');
        $limit=$request->get('limit',15);
        $page=$request->get('page',1);
        $skip=($page-1)*$limit;
        if($id){
            return ['status'=>1,'data'=>$this->find($id)];
        }
        $data=question_ins()
            ->with(['user'=>function($query){
                $query->select('id','username');
            }])
            ->orderBy('created_at','desc')
            ->limit($limit)
            ->skip($skip)
            ->get(['id','title','desc','user_id','created_at','updated_at']);
        return ['status'=>1,'data'=>$data];
    }
}
