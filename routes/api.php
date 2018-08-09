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

        //Routes for laboratory
        Route::get('/laboratories', 'LaboratoryController@index');
        Route::post('/laboratories', 'LaboratoryController@store');
        Route::get('/laboratories/{laboratories}', 'LaboratoryController@show');
        Route::patch('/laboratories/{laboratories}/laboratories', 'LaboratoryController@update');
        Route::patch('/laboratories/deactivate/{laboratory}','LaboratoryController@deactivate');
        Route::delete('/laboratories/{laboratories}', 'LaboratoryController@destroy');

        //admin access to patience
        Route::get('/patients', 'PatientController@index');
        Route::post('/patients', 'PatientController@store');
        Route::get('/patients/{patints}', 'PatientController@show');
        Route::patch('/patients/{patients}/patients', 'PatientController@update');
        Route::patch('/patients/deactivate/{patients}','PatientController@deactivate');
        Route::delete('/patients/{patients}', 'PatientController@destroy');

    });

    Route::group(['prefix' => 'patient', 'namespace' => 'Patient'], function()
    {
        Route::get('/', 'PatientController@dashboard');
        Route::get('/login', 'PatientController@index');
        Route::get('/register','PatientController@register');
        Route::post('/register', 'PatientController@store');
        Route::get('/patient/{patients}', 'PatientController@show');
        Route::patch('/patient/{patient}/patient', 'PatientController@update');
    });

    //Laboratory route

    Route::group(['prefix' => 'laboratories', 'namespace' => 'Laboratory'], function (){
        Route::get('/', 'LaboratoryController@dashboard');
        Route::patch('{laboratories}/laboratories', 'LaboratoryController@update');

    });
});




