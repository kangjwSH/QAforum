<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
function user_ins(){
    return new App\User;
}

function question_ins(){
    return new App\Question;
}

function answer_ins(){
    return new App\Answer;
}

function comment_ins(){
    return new App\Comment;
}

function is_logged_in(){
    return session()->get('user_id')?:false;
}

Route::get('/', function () {
    return view('index');
});

Route::any('api',function(){
    return ['version'=>0.1,'author'=>'James Kang'];
});

Route::any('user/signup',function(){
    return user_ins()->signup();
});

Route::any('api/userRead',function(){
    return user_ins()->userRead();
});

Route::any('user/login',function(){
    return user_ins()->login();
});

Route::any('user/logout',function(){
    return user_ins()->logout();
});

Route::any('api/changePassword',function(){
    return user_ins()->change_password();
});

Route::any('/user/exist',function(){
    return user_ins()->exist();
});

Route::any('api/resetPassword',function(){
    return user_ins()->reset_password();
});

Route::any('api/validateResetPassword',function(){
    return user_ins()->validate_reset_password();
});

Route::any('/question/add',function(){
   return question_ins()->add();
});

Route::any('api/question/change',function(){
    return question_ins()->change();
});

Route::any('api/question/read',function(){
    return question_ins()->read();
});

Route::any('api/question/remove',function(){
    return question_ins()->remove();
});

Route::any('api/answer/add',function(){
    return answer_ins()->add();
});

Route::any('api/answer/change',function(){
    return answer_ins()->change();
});

Route::any('api/answer/read',function(){
    return answer_ins()->read();
});

Route::any('api/answer/remove',function(){
    return answer_ins()->remove();
});

Route::any('api/answer/vote',function(){
    return answer_ins()->vote();
});

Route::any('api/comment/add',function(){
    return comment_ins()->add();
});

Route::any('api/comment/read',function(){
    return comment_ins()->read();
});

Route::any('api/comment/remove',function(){
    return comment_ins()->remove();
});

Route::any('test',function(){
    dd(user_ins()->is_logged_in());
});


