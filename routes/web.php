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

Route::get('/', function () {
    return view('welcome');
});

Route::any('api',function(){
    return ['version'=>0.1,'author'=>'James Kang'];
});

Route::any('api/signup',function(){
    $user=new App\User;
    return $user->signup();
});

Route::any('api/login',function(){
    $user=new App\User;
    return $user->login();
});

Route::any('api/logout',function(){
    $user=new App\User;
    return $user->logout();
});

Route::any('test',function(){
    $user=new App\User;
    dd($user->is_logged_in());
});


