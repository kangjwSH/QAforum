<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function add(Request $request){
        if(!is_logged_in()){
            return ['status'=>0,'msg'=>'login is required'];
        }

        $content=$request->get('content');
        $question_id=$request->get('question_id');
        $answer_id=$request->get('answer_id');
        $reply_to=$request->get('reply_to');

        if(!$content){
            return ['status'=>0,'msg'=>'content is required'];
        }

        if(
            (!$question_id&&!$answer_id)||
            ($question_id&&$answer_id)
        ){
            return ['status'=>0,'msg'=>'question_id or answer_id is required'];
        }

        $comment=comment_ins();

        if($question_id){
            $question=question_ins()->find($question_id);
            if(!$question){
                return ['status'=>0,'msg'=>'question does not exist'];
            }
            $comment->question_id=$question_id;
        }else if($answer_id){
            $answer=answer_ins()->find($answer_id);
            if(!$answer){
                return ['status'=>0,'msg'=>'answer does not exist'];
            }
            $comment->answer_id=$answer_id;
        };

        if($reply_to){
            $target=comment_ins()->find($reply_to);
            if(!$target){
                return ['status'=>0,'msg'=>'target comment does not exist'];
            }
            if($target->user_id==session('user_id')){
                return ['status'=>0,'msg'=>'cannot reply to yourself'];
            }
            $comment->reply_to=$reply_to;
        }

        $comment->content=$content;
        $comment->user_id=session('user_id');
        return $comment->save()?
            ['status'=>1,'id'=>$comment->id]:
            ['status'=>0,'msg'=>'db insert failed'];
    }

    public function read(Request $request){
        $question_id=$request->get('question_id');
        $answer_id=$request->get('answer_id');

        $comment=comment_ins();

        if(!$question_id&&!$answer_id){
            return ['status'=>0,'msg'=>'question_id or answer_id is required'];
        }
        if($question_id){
            $question=question_ins()->find($question_id);
            if(!$question){
                return ['status'=>0,'msg'=>'question does not exist'];
            }
            $data=$comment
                ->where('question_id',$question_id)
                ->get()
                ->keyBy('id');
        }else if($answer_id){
            $answer=answer_ins()->find($answer_id);
            if(!$answer){
                return ['status'=>0,'msg'=>'answer does not exist'];
            }
            $data=$comment
                ->where('answer_id',$answer_id)
                ->get()
                ->keyBy('id');
        }
        return ['status'=>1,'data'=>$data];
    }

    public function remove(Request $request){
        if(!is_logged_in()){
            return ['status'=>0,'msg'=>'login is required'];
        }

        $id=$request->get('id');
        if(!$id){
            return ['status'=>0,'msg'=>'id is required'];
        }

        $comment=comment_ins()->find($id);
        if(!$comment){
            return ['status'=>0,'msg'=>'comment does not exist'];
        }
        if($comment->user_id!=session('user_id')) {
            return ['status' => 0, 'msg' => 'permission denied'];
        }

        comment_ins()->where('reply_to',$id)->delete();
        return $comment->delete()?
            ['status'=>1]:
            ['status'=>0,'msg'=>'db delete failed'];
    }
}
