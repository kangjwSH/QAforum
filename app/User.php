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

     private function hasUsernameAndPassword(){
        $username=Request::get('username');
        $password=Request::get('password');
        if($username&&$password)
            return [$username,$password];
        return false;
    }

}
