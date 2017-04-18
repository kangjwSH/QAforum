<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnswerController extends Controller
{
    //
    public function add(Request $request){
        if(!is_logged_in()){
            return ['status'=>0,'msg'=>'login is required'];
        }

        $question_id=$request->get('question_id');
        $content=$request->get('content');
        if(!$question_id||!$content){
            return ['status'=>0,'msg'=>'question_id and content are required'];
        }
        $question=question_ins()
            ->find($question_id);
        if(!$question){
            return ['status'=>0,'msg'=>'question does not exist'];
        }

        $answered=answer_ins()
            ->where(['question_id'=>$question_id,'user_id'=>session('user_id')])
            ->count();

        if($answered){
            return ['status'=>0,'msg'=>'duplicate answer'];
        }

        $answer=answer_ins();
        $answer->question_id=$question_id;
        $answer->content=$content;
        $answer->user_id=session('user_id');

        return $answer->save()?
            ['status'=>1,'id'=>$answer->id]:
            ['status'=>0,'msg'=>'db insert failed'];
    }

    public function change(Request $request){
        if(!is_logged_in()){
            return ['status'=>0,'msg'=>'login is required'];
        }

        $id=$request->get('id');
        $content=$request->get('content');
        if(!$id||!$content){
            return ['status'=>0,'msg'=>'id and content is required'];
        }

        $answer=answer_ins()->find($id);
        if(!$answer){
            return ['status'=>0,'msg'=>'answer does not exist'];
        }
        if($answer->user_id!=session('user_id')){
            return ['status'=>0,'msg'=>'permission denied'];
        }

        $answer->content=$content;
        return $answer->save()?
            ['status'=>1]:
            ['status'=>0,'msg'=>'db update failed'];
    }

    public function read(Request $request){
        $id=$request->get('id');
        $question_id=$request->get('question_id');
        if(!$id&&!$question_id){
            return ['status'=>0,'msg'=>'id or question_id are required'];
        }
        if($id){
            $answer=answer_ins()->find($id);
            if(!$answer){
                return ['status'=>0,'msg'=>'answer does not exist'];
            }
            return ['status'=>1,'data'=>$answer];
        }

        if($question_id){
            $question=question_ins()->find($question_id);
            if(!$question){
                return ['status'=>0,'msg'=>'question does not exist'];
            }else{
                $answers=answer_ins()
                    ->where('question_id',$question_id)
                    ->get()
                    ->keyBy('id');
                return ['status'=>1,'data'=>$answers];
            }

        }
    }

    public function remove(Request $request){
        if(!is_logged_in()){
            return ['status'=>0,'msg'=>'login is required'];
        }

        $id=$request->get('id');
        if(!$id){
            return ['status'=>0,'msg'=>'id is required'];
        }

        $answer=answer_ins()->find($id);
        if(!$answer){
            return ['status'=>0,'msg'=>'answer does not exist'];
        }
        if($answer->user_id!=session('user_id')) {
            return ['status' => 0, 'msg' => 'permission denied'];
        }

        return $answer->delete()?
            ['status'=>1]:
            ['status'=>0,'msg'=>'db delete failed'];
    }
}
