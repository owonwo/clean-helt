<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'API'], function() {

    Route::post('login/{guard}', 'Auth\LoginController@login');

    Route::middleware('auth:hospital-api')->get('/hospital', function (Request $request) {
        return $request->user();
    });

<<<<<<< HEAD
    Route::get('/admin/hospitals', 'Admin\HospitalController@index');
    Route::post('/admin/hospitals', 'Admin\HospitalController@store');
    Route::get('/admin/hospitals/{hospital}', 'Admin\HospitalController@show');

=======
});
Route::group(['namespace' => 'Admin'],function(){
   Route::get('admin/doctors','DoctorController@index');
   Route::get('admin/doctors/{id}','DoctorController@show');
>>>>>>> f7a5560ffea844b5fe3b99fd98682d09ab144f4a
});