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
    Route::post('logout/{guard}','Auth\LoginController@logout');
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
        Route::patch('doctors/verify/{doctor}','DoctorController@verify')->name('admin.doctor.verify');
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

    //Start of all routes for doctor
    Route::group(['prefix' => 'doctor', 'namespace' => 'Doctor'], function() {
        Route::post('create','DoctorController@store')->name('doctor.create');
        Route::get('register/confirm','RegistrationConfirmationController@index')->name('doctor.register.confirm');
        Route::get('profile/{doctor}','DoctorController@show')->name('doctor.profile');
        Route::patch('update','DoctorController@update')->name('doctor.update');
        Route::get('hospital','DoctorController@hospitals')->name('doctor.hospital');
        Route::post('add-hospital','DoctorController@addHospital')->name('doctor.addHospital');
        Route::patch('{hospital}/accept-hospital','DoctorController@accept')->name('doctor.hospital.accept');
        Route::patch('{hospital}/decline-hospital','DoctorController@decline')->name('doctor.hospital.decline');
        Route::patch('{hospital}/remove-hospital','DoctorController@remove')->name('doctor.hospital.remove');
        Route::get('/active-hospitals','DoctorController@activeHospitals')->name('doctor.hospital.active');
        Route::get('/pending-hospitals','DoctorController@pendingHospitals')->name('doctor.hospital.pending');
        Route::get('/sent-hospitals','DoctorController@sentHospitals')->name('doctor.hospital.sent');
        Route::get('patients', 'PatientController@index')->name('doctor.patients');
        Route::get('patients/{patient}', 'PatientController@show')->name('doctor.patient');
        Route::get('patients/{patient}/prescriptions', 'PatientController@showPrescriptions')->name('doctor.patient.prescription');
        Route::get('patients/{patient}/labtest', 'PatientController@showLabTest')->name('doctor.patient.labTest');
        Route::get('patients/{patient}/records/{medicalRecord}', 'PatientController@showMedicalRecords');
        Route::post('patients/{patient}/diagnose', 'DiagnosisController@store')->name('doctor.patient.diagnosis');
        Route::get('patients/pending/patients', 'ProfileShareController@pending')->name('doctor.pending.patient');
        Route::patch('patients/pending/{profileShare}/accept', 'ProfileShareController@accept')->name('doctor.accept.patient');
        Route::patch('patients/pending/{profileShare}/decline', 'ProfileShareController@decline')->name('doctor.decline.patient');
        Route::delete('notification/{id}','NotificationController@delete')->name('doctor.notifications.read');
        Route::get('notifications','NotificationController@show')->name('doctor.notifications.show');
    });
    //End of all routes for doctor

    Route::group(['prefix' => 'patient', 'namespace' => 'Patient'], function() {
        Route::post('/register', 'PatientController@store');
        Route::get('/{patient}/medical-records','PatientController@showRecords');
        Route::get('profile', 'PatientController@show');
        Route::patch("/profile/update", 'PatientController@update');
        Route::get('/medical-record/{patient}', 'PatientController@showDate');
        Route::get('/{patient}/labtest', 'PatientController@showLabtest');
        Route::get('/{patient}/prescription', 'PatientController@showPrescription');
        Route::get('/verify/{email}/{verifyToken}', 'PatientController@verify')->name('patient.confirmation.mail');
        Route::patch('/{patient}/emergency', 'PatientController@edit');

        Route::get('profile/shares', 'ProfileShareController@index');
        Route::post('profile/shares', 'ProfileShareController@store')->name('patient.profile.share');
        Route::patch('profile/shares/{profileShare}/expire', 'ProfileShareController@expire');
        Route::patch('profile/shares/{profileShare}/extend', 'ProfileShareController@extend');
    });

    Route::group(['prefix' => 'laboratories', 'namespace' => 'Laboratory'], function (){ 
        Route::get('/profile', 'LaboratoryController@index');
        Route::patch('profile/update', 'LaboratoryController@update');

        Route::get('patient', 'ProfileShareController@index');
        Route::get('patient/pending', 'ProfileShareController@pending');

        Route::get('patient/{patient}/records', 'MedicalRecordController@index');
        Route::get('patient/{patient}/records/{medicalRecord}', 'MedicalRecordController@show');
        Route::patch('patient/{patient}/records/{medicalRecord}/{prescription}', 'MedicalRecordController@testrecord');

        Route::patch('patient/{profileShare}/accept', 'ProfileShareController@accept')->name('laboratory.accept.patient');
        Route::patch('patient/{profileShare}/decline', 'ProfileShareController@decline')->name('laboratory.decline.patient');
    });

    Route::group(['prefix' => 'hospital', 'namespace' => 'Hospital'], function() {
       Route::get('profile', 'ProfileController@index');
       Route::patch('profile', 'ProfileController@update');

       Route::get('patients', 'PatientController@index');
       Route::get('patients/pending', 'ProfileShareController@pending');
       Route::patch('patients/pending/{profileShare}/accept', 'ProfileShareController@accept')->name('hospital.profile.accept');
       Route::patch('patients/pending/{profileShare}/decline', 'ProfileShareController@decline');
       Route::patch('patients/{profileShare}/assign/{doctor}', 'PatientController@assign');

       Route::get('patients/{patient}/records', 'MedicalRecordController@index');
       Route::get('patients/{patient}/records/{medicalRecord}', 'MedicalRecordController@show');


       Route::get('doctors', 'DoctorController@index');
       Route::get('doctors/pending', 'DoctorController@pending');
       Route::get('doctors/sent', 'DoctorController@sent');
       Route::post('doctors/{doctor}/invite', 'DoctorController@invite');
       Route::patch('doctors/{doctor}/accept', 'DoctorController@accept');
       Route::patch('doctors/{doctor}/decline', 'DoctorController@decline');
       Route::delete('doctors/{doctor}/delete', 'DoctorController@remove');
    });

    Route::group(['prefix' => 'pharmacy', 'namespace' => 'Pharmacy'], function() {
        Route::get('profile', 'ProfileController@index');
        Route::patch('profile', 'ProfileController@update');

        Route::get('patients', 'PatientController@index');
        Route::get('patients/pending', 'ProfileShareController@pending');
        Route::patch('patients/pending/{profileShare}/accept', 'ProfileShareController@accept')->name('pharmacy.profile.accept');
        Route::patch('patients/pending/{profileShare}/decline', 'ProfileShareController@decline');

        Route::get('patients/{patient}/records', 'MedicalRecordController@index');
        Route::get('patients/{patient}/records/{medicalRecord}', 'MedicalRecordController@show');
        Route::patch('patients/{patient}/records/{medicalRecord}/{prescription}', 'MedicalRecordController@dispense');
    });
});

