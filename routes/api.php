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


    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
        Route::get('hospitals', 'HospitalController@index');
        Route::post('hospitals', 'HospitalController@store');
        Route::get('hospitals/{hospital}', 'HospitalController@show');
        Route::patch('hospitals/{hospital}', 'HospitalController@update');
        Route::delete('hospitals/{hospital}', 'HospitalController@destroy');

        Route::get('pharmacies', 'PharmacyController@index');
        Route::post('pharmacies', 'PharmacyController@store');
        Route::get('pharmacies/{pharmacy}', 'PharmacyController@show');
        Route::patch('pharmacies/{pharmacy}', 'PharmacyController@update');
        Route::delete('pharmacies/{pharmacy}', 'PharmacyController@destroy');



        //Routes for doctors
        Route::get('doctors','DoctorController@index');
        Route::get('doctors/{doctor}','DoctorController@show');
        Route::patch('doctors/verify/{doctor}','DoctorController@verify');
        Route::patch('doctors/activate/{doctor}','DoctorController@activate');
        Route::patch('doctors/deactivate/{doctor}','DoctorController@deactivate');
        Route::delete('doctors/destroy/{doctor}','DoctorController@destroy');
        Route::get('doctors/{id}','DoctorController@show');
        Route::patch('doctors/update/{doctor}','DoctorController@update');
    });
});


