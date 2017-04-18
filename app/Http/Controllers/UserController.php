<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function is_logged_in(){
        return session()->get('user_id')?:false;
    }

    //生成验证码
    private function generate_captcha(){
        return rand(100000,999999);
    }

    private function send_sms(){
        return true;
    }

    public function signup(Request $request){
        $username=$request->get('username');
        $password=$request->get('password');
        if(!($username&&$password))
            return ['status'=>0,'msg'=>'用户名和密码皆不可为空'];

        $user=new User();
        $user_exists=user_ins()
            ->where('username',$username)
            ->exists();

        if($user_exists)
            return ['status'=>0,'msg'=>'用户名已存在'];

        $md5_password=md5($password);
        $user->password=$md5_password;
        $user->username=$username;

        if($user->save()){
            return ['status'=>1,'id'=>$user->id];
        }else{
            return ['status'=>0,'msg'=>'数据库保存失败！！'];
        }
    }

    public function login(Request $request){
        $username=$request->get('username');
        $password=$request->get('password');
        if(!($username&&$password))
            return ['status'=>0,'msg'=>'用户名和密码皆不可为空'];

        //检查用户是否存在
        $user=user_ins()
            ->where('username',$username)
            ->first();

        if(!$user)
            return ['status'=>0,'msg'=>'用户名不存在'];

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

    public function change_password(Request $request){
        if(!$this->is_logged_in()){
            return ['status'=>0,'login required'];
        }

        $old_password=$request->get('old_password');
        $new_password=$request->get('new_password');
        if(!($old_password&&$new_password)){
            return ['status'=>0,'old password and new password are required'];
        }
        $user=user_ins()->find(session('user_id'));
        $use_password=$user->password;
        if($use_password!=md5($old_password)){
            return ['status'=>0,'invalid old password'];
        }
        $user->password=md5($new_password);
        return $user->save()?
            ['status'=>1]:
            ['status'=>0,'msg'=>'db update failed'];
    }

    public function exist(Request $request){
        $username=$request->get('username');
        $count=user_ins()
            ->where('username',$username)
            ->count();
        return ['status'=>1,'count'=>$count];
    }

    public function reset_password(Request $request){
        $current_time=time();
        $last_sms_time=session('last_sms_time');
        if($last_sms_time&&$current_time-$last_sms_time<10){
            return ['status'=>0,'msg'=>'max frequency reached'];
        }

        $phone=$request->get('phone');
        if(!$phone){
            return ['status'=>0,'msg'=>'phone is required'];
        }

        $user=user_ins()
            ->where('phone',$phone)
            ->first();

        if(!$user){
            return ['status'=>0,'msg'=>'invalid phone number'];
        }

        session()->put('last_sms_time',time());
        session()->save();

        $captcha=$this->generate_captcha();
        $user->phone_captcha=$captcha;
        if($user->save()){
            $this->send_sms();
            return ['status'=>1];
        }
        return ['status'=>0,'msg'=>'db update failed'];
    }

    public function validate_reset_password(Request $request){
        $phone=$request->get('phone');
        $phone_captcha=$request->get('phone_captcha');
        $new_password=$request->get('new_password');
        if(!$phone||!$phone_captcha||!$new_password){
            return ['status'=>0,'msg'=>'new password,phone and phone captcha are required'];
        }
        $user=user_ins()
            ->where([
                'phone'=>$phone,
                'phone_captcha'=>$phone_captcha
            ])->first();
        if(!$user){
            return ['status'=>0,'msg'=>'invalid phone or phone captcha'];
        }
        $user->password=md5($new_password);
        session()->forget('last_sms_time');
        return $user->save()?
            ['status'=>1]:
            ['status'=>0,'msg'=>'db update failed'];
    }

    public function userRead(Request $request){
        $id=$request->get('id');
        if(!$id){
            return ['status'=>0,'id is required'];
        }
        $get=['username','avatar_url','intro'];
        $data=user_ins()->find( $id,$get);
        $answer_count=answer_ins()
            ->where('user_id', $id)
            ->count();
        $question_count=question_ins()
            ->where('user_id', $id)
            ->count();
        $data['answer_count']=$answer_count;
        $data['question_count']=$question_count;
        return ['status'=>1,'data'=>$data];
    }

    public function getSession(){
        return session()->all();
    }


}
