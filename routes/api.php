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
        Route::get('/laboratories/{laboratory}', 'LaboratoryController@show');
        Route::patch('/laboratories/{laboratory}', 'LaboratoryController@update');
        Route::patch('/laboratories/deactivate/{laboratory}','LaboratoryController@deactivate');
        Route::delete('/laboratories/{laboratory}', 'LaboratoryController@destroy');

        //admin access to patients
        Route::get('/patients', 'PatientController@index');
        Route::post('/patients', 'PatientController@store');
        Route::get('/patients/{patient}', 'PatientController@show');
        Route::patch('/patients/{patient}', 'PatientController@update');
        Route::patch('/patients/{patient}/deactivate','PatientController@deactivate');
        Route::delete('/patients/{patient}', 'PatientController@destroy');
        //A patient can view all his medical records from this route


        //Admin can create an Admin
        Route::post('/create','AdminController@store')->name('admin.store');
    });

    Route::group(['prefix' => 'doctor', 'namespace' => 'Doctor'], function() {
        Route::post('create','DoctorController@store')->name('doctor.create');
        Route::patch('{doctor}/update','DoctorController@update')->name('doctor.update');
        Route::get('patients', 'PatientController@index');
        Route::get('patients/{patient}', 'PatientController@show');
        Route::post('patients/{patient}/diagnose', 'DiagnosisController@store')->name('doctor.patient.diagnosis');
    });
    Route::group(['prefix' => 'patient', 'namespace' => 'Patient'], function() {
        Route::get('/', 'PatientController@dashboard');
        Route::get('/login', 'PatientController@index');
        Route::get('/register','PatientController@register');
        Route::post('/register', 'PatientController@store');
        Route::get('/{patient}/medical-records','PatientController@showRecords');
        Route::get('/patient/{patient}', 'PatientController@show');
        Route::patch('/patient/{patient}', 'PatientController@update');

        Route::get('profile/shares', 'ProfileShareController@index');
        Route::post('profile/shares', 'ProfileShareController@store');
        Route::patch('profile/shares/{profileShare}/expire', 'ProfileShareController@expire');
        Route::patch('profile/shares/{profileShare}/extend', 'ProfileShareController@extend');
    });

    //Laboratory route

    Route::group(['prefix' => 'laboratories', 'namespace' => 'Laboratory'], function (){
        Route::get('/', 'LaboratoryController@dashboard');
        Route::patch('{laboratories}/laboratories', 'LaboratoryController@update');
    });
});




