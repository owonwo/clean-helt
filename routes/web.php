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

Route::group(
    ['prefix' => 'admin'],
    function () {
        //main routes
        Route::get('login', 'Auth\AdminLoginController@showLoginForm')
            ->name('admin.login');
        Route::post('login', 'Auth\AdminLoginController@login');

        //login routes
        Route::group(
            ['middleware' => 'auth-session:admin'],
            function () {
                Route::get('/{any?}', 'AdminController@index')->name('admin.dashboard');
                Route::post('logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
            }
        );
    }
);

Route::get('clients/{any?}', function () {
    return view('all', ['user' => 'Patient']);
})
    ->middleware('auth-session:patient')
    ->where('any', '(.){0,}')->name('patient.dashboard');

Route::get('doctors/{any?}', function (Request $request) {
    return view('all', ['user' => 'Doctor']);
})->middleware('auth-session:doctor')->where('any', '(.){0,}')->name('doctor.dashboard');

Route::get('pharmacy/{any?}', function () {
    return view('all', ['user' => 'Phamarcy']);
})
    ->middleware('auth-session:pharmacy')
    ->where('any', '(.){0,}')->name('pharmacy.dashboard');

Route::get('lab/{any?}', function () {
    return view('all', ['user' => 'Laboratory']);
})
    ->middleware('auth-session:laboratory')
    ->where('any', '(.){0,}');

Route::get('hospital/{any?}', function () {
    return view('all', ['user' => 'Hospital']);
})
    ->middleware('auth-session:hospital')
    ->where('any', '(.){0,}')->name('hospital.dashboard');

Route::get('/make-fake-session/{type}', function (Request $request, $type) {
    $emails = [
        'doctor' => 'dessie.conrey@gmail.com',
        'patient' => 'rocio.daniel@example.com',
        'hospital' => 'dhettinger@example.com',
        'pharmacy' => 'jeramie.koelpin@example.com',
    ];

    if (auth()->guard($type)->attempt(['email' => $emails[$type], 'password' => 'secret'], false)) {
        session()->regenerate();

        return redirect()->intended(route($type . '.dashboard', 'dashboard'));
    }
});

Route::post('/login/{type}', function (Request $request, $type) {
    if (auth()->guard($type)->attempt(['email' => request('email'), 'password' => request('password')], false)) {
        session()->regenerate();

        return redirect()->intended(route($type . '.dashboard', 'dashboard'));
    }

    return redirect()->back()->withErrors(['login' => 'Invalid username or password.']);
});

Route::get('/remove-fake-session', function (Request $request) {
    auth()->logout();
    session()->invalidate();

    return redirect('login');
});

Auth::routes();
