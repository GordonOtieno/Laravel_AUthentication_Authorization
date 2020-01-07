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

Route::get('/register','Security\RegisterController@register');
Route::post('register','Security\RegisterController@registerUser');
Route::get('/login','Security\LoginController@login');
Route::post('login', 'Security\LoginController@postLogin');
Route::post('/logout','Security\LoginController@logout');
Route::get('/activate/{email}/{code}','Security\ActivationController@activate');
Route::get('/forgot_password','Security\ForgotPassword@forgot');
Route::post('/forgot_password','Security\ForgotPassword@password');
Route::get('/reset_password/{email}/{code}','Security\ForgotPassword@reset');