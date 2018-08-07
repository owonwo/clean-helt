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

    Route::get('/admin/hospitals', 'Admin\HospitalController@index');
    Route::post('/admin/hospitals', 'Admin\HospitalController@store');
    Route::get('/admin/hospitals/{hospital}', 'Admin\HospitalController@show');

});
Route::group(['namespace' => 'API\Admin'],function(){
   Route::get('admin/doctors','DoctorController@index');
   Route::get('admin/doctors/{doctor}','DoctorController@show');
   Route::patch('admin/doctors/verify/{doctor}','DoctorController@verify');
   Route::patch('admin/doctors/activate/{doctor}','DoctorController@activate');
   Route::patch('admin/doctors/deactivate/{doctor}','DoctorController@deactivate');
   Route::get('admin/doctors/{id}','DoctorController@show');
});