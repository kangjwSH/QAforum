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
    public function signup(){
        $hasUsernameAndPassword=$this->hasUsernameAndPassword();
       if(!$hasUsernameAndPassword)
           return ['status'=>0,'msg'=>'用户名和密码皆不可为空'];

       $username=$hasUsernameAndPassword[0];
       $password=$hasUsernameAndPassword[1];

       $user_exists=$this
           ->where('username',$username)
           ->exists();

       if($user_exists)
           return ['status'=>0,'msg'=>'用户名已存在'];

       $md5_password=md5($password);
       $this->password=$md5_password;
       $this->username=$username;

       if($this->save()){
           return ['status'=>1,'id'=>$this->id];
       }else{
           return ['status'=>0,'msg'=>'数据库保存失败！！'];
       }
    }

    public function userRead(){
        if(!Request::get('id')){
            return ['status'=>0,'id is required'];
        }
        $get=['username','avatar_url','intro'];
        $data=$this->find(Request::get('id'),$get);
        $answer_count=answer_ins()->where('user_id',Request::get('id'))->count();
        $question_count=question_ins()->where('user_id',Request::get('id'))->count();
        $data['answer_count']=$answer_count;
        $data['question_count']=$question_count;
        return ['status'=>1,'data'=>$data];
    }
    public function login(){
        //检查请求过来的用户名和密码是否为空
        $hasUsernameAndPassword=$this->hasUsernameAndPassword();
        if(!$hasUsernameAndPassword)
            return ['status'=>0,'msg'=>'用户名和密码皆不可为空'];
        $username=$hasUsernameAndPassword[0];
        $password=$hasUsernameAndPassword[1];

        //检查用户是否存在
        $user=$this
            ->where('username',$username)
            ->first();
        if(!$user)
            return ['status'=>0,'msg'=>'用户不存在'];

        //检查密码是否正确
        $md5_password=md5($password);
        $md5_password_db=$user->password;
        if($md5_password!=$md5_password_db)
            return ['status'=>0,'msg'=>'密码错误'];

        //成功
        session()->put('username',$user->username);
        session()->put('user_id',$user->id);
        session()->save();
        return ['status'=>1,'user_id'=>$user->id];
    }

    public function logout(){
        session()->forget('username');
        session()->forget('user_id');
        return ['status'=>1];
    }

    public function is_logged_in(){
        return session()->get('user_id')?:false;
    }

    public function change_password(){
        if(!$this->is_logged_in()){
            return ['status'=>0,'login required'];
        }
        if(!Request::get('old_password')||!Request::get('old_password')){
            return ['status'=>0,'old password and new password are required'];
        }
        $user=$this->find(session('user_id'));
        $use_password=$user->password;
        if($use_password!=md5(Request::get('old_password'))){
            return ['status'=>0,'invalid old password'];
        }
        $user->password=md5(Request::get('new_password'));
        return $user->save()?
            ['status'=>1]:
            ['status'=>0,'msg'=>'db update failed'];
    }

    public function reset_password(){
        $current_time=time();
        $last_sms_time=session('last_sms_time');
        if($last_sms_time&&$current_time-$last_sms_time<10){
            //return ['current_time'=>$current_time,'last_sms_time'=>$last_sms_time];
            return ['status'=>0,'msg'=>'max frequency reached'];
        }
        if(!Request::get('phone')){
            return ['status'=>0,'msg'=>'phone is required'];
        }
        $user=$this->where('phone',Request::get('phone'))->first();
        if(!$user){
            return ['status'=>0,'msg'=>'invalid phone number'];
        }

        $captcha=$this->generate_captcha();
        $user->phone_captcha=$captcha;
       if($user->save()){
           $this->send_sms();
           session()->put('last_sms_time',time());
           session()->save();
          return ['status'=>1];
       }
       return ['status'=>0,'msg'=>'db update failed'];

    }

    //生成验证码
    public function generate_captcha(){
        return rand(100000,999999);
    }

    public function send_sms(){
        return true;
    }

    public function validate_reset_password(){
        if(!Request::get('phone')||!Request::get('phone_captcha')||!Request::get('new_password')){
            return ['status'=>0,'msg'=>'new password,phone and phone captcha are required'];
        }
        $user=$this
            ->where([
                'phone'=>Request::get('phone'),
                'phone_captcha'=>Request::get('phone_captcha')
            ])->first();
        if(!$user){
            return ['status'=>0,'msg'=>'invalid phone or phone captcha'];
        }
        $user->password=md5(Request::get('new_password'));
        return $user->save()?
            ['status'=>1]:
            ['status'=>0,'msg'=>'db update failed'];
    }

     private function hasUsernameAndPassword(){
        $username=Request::get('username');
        $password=Request::get('password');
        if($username&&$password)
            return [$username,$password];
        return false;
    }

    public function answers(){
        return $this
            ->belongsToMany('App\Answer')
            ->withPivot('vote')
            ->withTimestamps();
    }
    public function exist(){
        $count=$this->where('username',Request::get('username'))->count();
        return ['status'=>1,'count'=>$count];
    }



}
