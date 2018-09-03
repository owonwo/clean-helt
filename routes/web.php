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

Route::post('/password/reset/doctors', 'API\Doctor\ResetPasswordController@reset')->name('doctor.password.reset');
Route::get('/password/reset/doctors/{token}', 'API\Doctor\ResetPasswordController@showResetForm')->name('doctor.password.show');
Route::get('/password/email/doctors', 'API\Doctor\ForgotPasswordController@sendResetLinkEmail');
Route::get('/password/reset/doctors/', 'API\Doctor\ForgotPasswordController@showLinkRequestForm');
Route::post('/password/reset/hospitals', 'API\Hospital\ResetPasswordController@reset')->name('hospital.password.reset');
Route::get('/password/reset/hospitals/{token}', 'API\Hospital\ResetPasswordController@showResetForm')->name('hospital.password.show');
Route::post('/password/reset/pharmacies', 'API\Pharmacy\ResetPasswordController@reset')->name('pharmacy.password.reset');
Route::get('/password/reset/pharmacies/{token}', 'API\Pharmacy\ResetPasswordController@showResetForm')->name('pharmacy.password.show');

Route::group(['namespace' => 'API'], function () {
    /*
     * This is going to be the laboratory route
     * this route is going to contain all labs routes
     */
    Route::group(['prefix' => 'laboratories', 'namespace' => 'Laboratory'], function () {
        /* @laboratory password reset */
        Route::post('/password/email', 'LaboratoryForgotPasswordController@sendResetLinkEmail')->name('laboratory.password.email');
        Route::get('/password/reset', 'LaboratoryForgotPasswordController@showLinkRequestForm')->name('laboratory.password.request');
        Route::post('/password/reset', 'LaboratoryResetPasswordController@reset');
        Route::get('/password/reset/{token}', 'LaboratoryResetPasswordController@showResetForm')->name('laboratory.password.reset');
    });

    /*
     *
     * This route contains all list of patience route
     * please just start here
     *
     */

    Route::group(['prefix' => 'patients', 'namespace' => 'Patient'], function () {
        /* @laboratory password reset */
        Route::post('/password/email', 'PatientForgotPassword@sendResetLinkEmail')->name('patient.password.email');
        Route::get('/password/reset', 'PatientForgotPassword@showLinkRequestForm')->name('patient.password.request');
        Route::post('/password/reset', 'PatientResestPassword@reset');
        Route::get('/password/reset/{token}', 'PatientResestPassword@showResetForm')->name('patient.password.reset');
    });
});

Route::get('clients/{any}', function () { return view('all', ['user' => 'Patient']); })->where('any', '(.){0,}');

Route::get('doctors/{any}', function (Request $request) {
    return view('all', ['user' => 'Doctor']);
})->middleware('auth:doctor')->where('any', '(.){0,}')->name('doctor.dashboard');

Route::get('pharmacy/{any}', function () { return view('all', ['user' => 'Phamarcy']); })->where('any', '(.){0,}');
Route::get('lab/{any}', function () { return view('all', ['user' => 'Laboratory']); })->where('any', '(.){0,}');
Route::get('hospital/{any}', function () { return view('all', ['user' => 'Hospital']); })->where('any', '(.){0,}');

Route::get('/make-fake-session', function (Request $request) {
    if (auth()->guard('doctor')->attempt(['email' => 'dessie.conroy@gmail.com', 'password' => 'secret'], false)) {
        session()->regenerate();
        return redirect()->route('doctor.dashboard', 'dashboard');
    }
});

Route::get('/remove-fake-session', function (Request $request) {
    auth()->guard('doctor')->logout();
    session()->invalidate();

    return redirect('login');
});

Auth::routes();
