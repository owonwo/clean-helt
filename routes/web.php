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

Route::post('/password/reset/doctors','API\Auth\ResetPasswordController@reset')->name('doctor.password.reset');
Route::get('/password/reset/doctors/{token}','API\Auth\ResetPasswordController@showResetForm');
Route::get('/password/email/doctors','API\Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('/password/reset/doctors/','API\Auth\ForgotPasswordController@showLinkRequestForm');

Auth::routes();

