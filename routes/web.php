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

function common_ins(){
    return new App\Common;
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





Route::any('getSession','UserController@getSession');

Route::any('user/signup','UserController@signup');
Route::any('user/login','UserController@login');
Route::any('user/logout','UserController@logout');
Route::any('user/changePassword','UserController@change_password');
Route::any('user/exist','UserController@exist');
Route::any('user/resetPassword','UserController@reset_password');
Route::any('user/userRead','UserController@userRead');
Route::any('user/validateResetPassword','UserController@validate_reset_password');

Route::any('question/add','QuestionController@add');
Route::any('question/change','QuestionController@change');
Route::any('question/remove','QuestionController@remove');
Route::any('question/read','QuestionController@read');



Route::any('answer/add','AnswerController@add');
Route::any('answer/change','AnswerController@change');
Route::any('answer/read','AnswerController@read');
Route::any('answer/remove','AnswerController@remove');

Route::any('api/answer/vote',function(){
    return answer_ins()->vote();
});

Route::any('comment/add','CommentController@add');
Route::any('comment/read','CommentController@read');

Route::any('common/getTimeline','CommonController@getTimeline');

Route::any('comment/remove','CommentController@remove');

Route::get('tpl/page/home',function(){
    return view('page.home');
});

Route::get('tpl/page/register',function(){
    return view('page.register');
});

Route::get('tpl/page/login',function(){
    return view('page.login');
});

Route::get('tpl/page/questionAdd',function(){
    return view('page.questionAdd');
});

Route::any('test2','UserController@test');



