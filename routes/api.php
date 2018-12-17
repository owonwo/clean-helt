<?php

use Illuminate\Http\Request;

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

Route::group(['namespace' => 'API'], function () {
    Route::get('entity/{type?}', 'General\EntityController@index');

    Route::post('login/{guard}', 'Auth\LoginController@newLogin')->middleware('oauth.providers');
    Route::post('logout/{guard}', 'Auth\LoginController@logout');
    Route::middleware('auth:hospital-api')->get('/hospital', function (Request $request) {
        return $request->user();
    });

    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
        Route::get('users/counts', 'AdminController@getUsersCount');
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
        Route::get('doctors', 'DoctorController@index');
        Route::get('doctors/{doctor}', 'DoctorController@show');
        Route::patch('doctors/verify/{doctor}', 'DoctorController@verify')->name('admin.doctor.verify');
        Route::patch('doctors/activate/{doctor}', 'DoctorController@activate');
        Route::patch('doctors/deactivate/{doctor}', 'DoctorController@deactivate');
        Route::delete('doctors/destroy/{doctor}', 'DoctorController@destroy');
        Route::get('doctors/{doctor}', 'DoctorController@show');
        Route::patch('doctors/update/{doctor}', 'DoctorController@update');

        //Routes for laboratory
        Route::get('/laboratories', 'LaboratoryController@index');
        Route::post('/laboratories', 'LaboratoryController@store');
        Route::get('/laboratories/{laboratory}', 'LaboratoryController@show');
        Route::patch('/laboratories/{laboratory}', 'LaboratoryController@update');
        Route::patch('/laboratories/deactivate/{laboratory}', 'LaboratoryController@deactivate');
        Route::delete('/laboratories/{laboratory}', 'LaboratoryController@destroy');

        //admin access to patients
        Route::get('/patients', 'PatientController@index');
        Route::post('/patients', 'PatientController@store');
        Route::get('/patients/{patient}', 'PatientController@show');
        Route::patch('/patients/{patient}', 'PatientController@update');
        Route::patch('/patients/{patient}/deactivate', 'PatientController@deactivate');
        Route::delete('/patients/{patient}', 'PatientController@destroy');
        //A patient can view all his medical records from this route

        //Admin can create an Admin
        Route::post('/create', 'AdminController@store')->name('admin.store');
    });

    //Start of all routes for doctor
    Route::group(['prefix' => 'doctor', 'namespace' => 'Doctor'], function () {
        Route::post('create', 'DoctorController@store')->name('doctor.create');
        Route::get('register/confirm', 'RegistrationConfirmationController@index')->name('doctor.register.confirm');
        Route::get('profile', 'DoctorController@show')->name('doctor.profile');
        Route::patch('update', 'DoctorController@update')->name('doctor.update');
        Route::get('hospital', 'DoctorController@hospitals')->name('doctor.hospital');
        Route::post('add-hospital', 'DoctorController@addHospital')->name('doctor.addHospital');
        Route::patch('{hospital}/accept-hospital', 'DoctorController@accept')->name('doctor.hospital.accept');
        Route::patch('{hospital}/decline-hospital', 'DoctorController@decline')->name('doctor.hospital.decline');
        Route::patch('{hospital}/remove-hospital', 'DoctorController@remove')->name('doctor.hospital.remove');
        Route::get('/active-hospitals', 'DoctorController@activeHospitals')->name('doctor.hospital.active');
        Route::get('/pending-hospitals', 'DoctorController@pendingHospitals')->name('doctor.hospital.pending');
        Route::get('/sent-hospitals', 'DoctorController@sentHospitals')->name('doctor.hospital.sent');
        Route::get('patients', 'PatientController@index')->name('doctor.patients');
        Route::get('patients/pending', 'ProfileShareController@pending')->name('doctor.pending.patient');
        Route::get('patients/{patient}', 'PatientController@show')->name('doctor.patient');
        Route::post('patients/{patient}/referral', 'PatientController@refer')->name('doctor.patient.refer');
        Route::get('patients/{patient}/diagnosis', 'PatientController@diagnosis');
        Route::get('patients/{patient}/prescriptions', 'PatientController@showPrescriptions')->name('doctor.patient.prescription');
        Route::get('patients/{patient}/labtest', 'PatientController@showLabTest')->name('doctor.patient.labTest');
        Route::get('patients/{patient}/records/{medicalRecord}', 'PatientController@showMedicalRecords');
        Route::post('patients/{patient}/diagnose', 'DiagnosisController@store')->name('doctor.patient.diagnosis');
        Route::patch('patients/{patient}/diagnose/{diagnosis}', 'DiagnosisController@update')->name('doctor.patient.patch.diagnosis');

        Route::get('patients/{patient}/allergies', 'AllergyController@index')->name('doctor.patients.allergies');
        Route::post('patients/{patient}/allergies', 'AllergyController@store');
        Route::patch('patients/{patient}/allergies/{allergy}', 'AllergyController@update')->name('doctor.patients.allergies.update');
        Route::delete('patients/{patient}/allergies/{allergy}', 'AllergyController@delete')->name('doctor.patients.allergies.delete');

        Route::get('patients/{patient}/immunizations', 'ImmunizationController@index')->name('doctor.patients.immunizations');
        Route::post('patients/{patient}/immunizations', 'ImmunizationController@store');
        Route::patch('patients/{patient}/immunizations/{immunization}', 'ImmunizationController@update')->name('doctor.patients.immunizations.update');
        Route::delete('patients/{patient}/immunizations/{immunization}', 'ImmunizationController@delete')->name('doctor.patients.immunizations.delete');
        
        Route::get('patients/{patient}/family-records', 'FamilyRecordController@index')->name('doctor.patients.family-records');
        Route::post('patients/{patient}/family-records', 'FamilyRecordController@store');
        Route::patch('patients/{patient}/family-records/{familyRecord}', 'FamilyRecordController@update')->name('doctor.patients.family-records.update');
        Route::delete('patients/{patient}/family-records/{familyRecord}', 'FamilyRecordController@delete')->name('doctor.patients.family-records.delete');

        Route::get('patients/{patient}/hospitalizations', 'HospitalizationController@index')->name('doctor.patients.hospitalizations');
        Route::post('patients/{patient}/hospitalizations', 'HospitalizationController@store');
        Route::patch('patients/{patient}/hospitalizations/{hospitalize}', 'HospitalizationController@update')->name('doctor.patients.hospitalizations.update');
        Route::delete('patients/{patient}/hospitalizations/{hospitalize}', 'HospitalizationController@delete')->name('doctor.patients.hospitalizations.delete');

        Route::get('patients/{patient}/emergency-contacts', 'EmergencyContactController@index')->name('doctor.patients.emergency-contacts');
        Route::post('patients/{patient}/emergency-contacts', 'EmergencyContactController@store');
        Route::patch('patients/{patient}/emergency-contacts/{emergencyContact}', 'EmergencyContactController@update')->name('doctor.patients.emergency-contacts.update');
        Route::delete('patients/{patient}/emergency-contacts/{emergencyContact}', 'EmergencyContactController@delete')->name('doctor.patients.emergency-contacts.delete');

        Route::get('patients/{patient}/hospital-contacts', 'HospitalContactController@index')->name('doctor.patients.hospital-contacts');
        Route::post('patients/{patient}/hospital-contacts', 'HospitalContactController@store');
        Route::patch('patients/{patient}/hospital-contacts/{hospitalContacts}', 'HospitalContactController@update')->name('doctor.patients.hospital-contacts.update');
        Route::delete('patients/{patient}/hospital-contacts/{hospitalContacts}', 'HospitalContactController@delete')->name('doctor.patients.hospital-contacts.delete');

        Route::get('patients/{patient}/health-insurance', 'HealthInsuranceController@index')->name('doctor.patients.health-insurance');
        Route::post('patients/{patient}/health-insurance', 'HealthInsuranceController@store');
        Route::patch('patients/{patient}/health-insurance/{healthInsurance}', 'HealthInsuranceController@update')->name('doctor.patients.health-insurance.update');
        Route::delete('patients/{patient}/health-insurance/{healthInsurance}', 'HealthInsuranceController@delete')->name('doctor.patients.health-insurance.delete');

        Route::get('patients/{patient}/medical-history', 'MedicalHistoryController@index')->name('doctor.patients.medical-history');
        Route::post('patients/{patient}/medical-history', 'MedicalHistoryController@store');
        Route::patch('patients/{patient}/medical-history/{medicalHistory}', 'MedicalHistoryController@update')->name('doctor.patients.medical-history.update');
        Route::delete('patients/{patient}/medical-history/{medicalHistory}', 'MedicalHistoryController@delete')->name('doctor.patients.medical-history.delete');
        
        Route::get('patients/{patient}/medical-checkups', 'MedicalCheckupController@index')->name('doctor.patients.medical-checkup');
        Route::post('patients/{patient}/medical-checkups', 'MedicalCheckupController@store');
        Route::patch('patients/{patient}/medical-checkups/{medicalCheckup}', 'MedicalCheckupController@update')->name('doctor.patients.medical-checkup.update');
        Route::delete('patients/{patient}/medical-checkups/{medicalCheckup}', 'MedicalCheckupController@delete')->name('doctor.patients.medical-checkup.delete');

        Route::get('patients/accepted/patients', 'ProfileShareController@accepted')->name('doctor.patient.accepted');
        Route::get('patients/pending/patients', 'ProfileShareController@pending')->name('doctor.pending.patient');

        Route::patch('patients/pending/{profileShare}/accept', 'ProfileShareController@accept')->name('doctor.accept.patient');
        Route::patch('patients/pending/{profileShare}/decline', 'ProfileShareController@decline')->name('doctor.decline.patient');

        Route::delete('notification/{id}', 'NotificationController@delete')->name('doctor.notifications.read');
        Route::get('notifications', 'NotificationController@show')->name('doctor.notifications.show');
    });
    //End of all routes for doctor

    Route::post('patient/register', 'Patient\PatientController@store')->name('patient.register');
    Route::get('patient/verify/{email}/{verifyToken}', 'Patient\PatientController@verify')->name('patient.confirmation.mail');
    Route::group(['prefix' => 'patient', 'namespace' => 'Patient', 'middleware' => ['api', 'auth:patient-api']], function () {
        // Patient Children Routes
        Route::group(
            ['prefix' => 'children'],
            function () {
                Route::post('', 'LinkAccountController@store')->name('register.child');
                Route::get('', 'LinkAccountController@showLinkedAccounts')->name('register.child');
                Route::post('unlink', 'LinkAccountController@unlinkAccount')->name('unlink-account');
                Route::post('switch-account', 'LinkAccountController@switchAccount')->name('switch-account');
            }
        );

        Route::get('medical-records', 'PatientController@showRecords');
        Route::get('profile', 'PatientController@show');
        Route::patch('/profile/update', 'PatientController@update');
        Route::post('/profile/update/image', 'PatientController@updateAvatar');
        Route::get('/labtest', 'PatientController@showLabtest');
        Route::get('/prescription', 'PatientController@showPrescription');
        Route::patch('/{patient}/emergency', 'PatientController@edit');
        // Patient Creates Immunization records
        Route::get('/record/immunization', 'ImmunizationController@index');
        Route::post('/record/immunization', 'ImmunizationController@store')->name('patient.record.immunization');
        Route::patch('update/{immunization}/immunization', 'ImmunizationController@update')->name('patient.update.immunization');
        // Patient Updates Hospitaliation records
        Route::get('/record/hospitalization', 'HospitalizationController@index');
        Route::post('/record/hospitalization', 'HospitalizationController@store')->name('patient.record.hospitalization');
        Route::patch('/record/{hospitalize}/hospitalization', 'HospitalizationController@update')->name('patient.update.hospitalize');

        Route::resource('/record/emergency-contacts', 'EmergencyContactController', [
            'only' => ['store', 'index', 'destroy','update'],
        ]);

        //Patient Updates allergies
        Route::get('/record/allergy', 'AllergyController@index')->name('patient.get.allergy');
        Route::post('/record/allergy', 'AllergyController@store')->name('patient.record.allergy');
        Route::patch('update/{allergy}/allergy', 'AllergyController@update')->name('patient.update.allergy');
        //Patient  updates health insurance provider
        Route::get('/record/health-insurance', 'HealthInsuranceController@index');
        Route::post('/record/health-insurance', 'HealthInsuranceController@store')->name('patient.record.health-insurance');
        Route::patch('/record/{healthInsurance}/health-insurance', 'HealthInsuranceController@update')->name('patient.health-insurance.update');
        Route::delete('/record/{healthInsurance}/health-insurance', 'HealthInsuranceController@destroy')->name('patient.health-insurance.destroy');
        //Patient  updates medical history
        Route::get('/record/medical-history', 'MedicalHistoryController@index');
        Route::post('/record/medical-history', 'MedicalHistoryController@store')->name('patient.record.history');
        Route::patch('/record/{medicalHistory}/medical-history', 'MedicalHistoryController@update')->name('patient.update.history');
        Route::delete('/record/{medicalHistory}/medical-history', 'MedicalHistoryController@delete')->name('patient.delete.record');
        //TODO: Preferred Replacement for the FamilyHistory routes
        // Route::resource('/record/family-history', 'FamilyRecordController', ['except' => ['edit', 'create', 'show', 'update']]);
        Route::get('/record/family-history', 'FamilyRecordController@index');
        Route::post('/record/family-history', 'FamilyRecordController@store')->name('patient.record.family');
        Route::patch('record/{familyRecord}/family-history', 'FamilyRecordController@update')->name('patient.update.family');
        Route::delete('/record/family-history/{familyRecord}', 'FamilyRecordController@destroy')->name('patient.destroy.family');
        //Patient Hospital Contacts
        Route::post('/record/hospital-contact', 'HospitalContactsController@store')->name('patient.hospital-contact');
        Route::patch('/record/hospital-contact/{hospitalContact}', 'HospitalContactsController@update')->name('patient.hospital-contact.update');
        Route::delete('/record/hospital-contact/{hospitalContact}', 'HospitalContactsController@destroy')->name('patient.hospital-contact.delete');
        Route::get('/record/hospital-contact', 'HospitalContactsController@index')->name('patient.hospital-contact.get');
        //End

        //Emergency Route
        Route::get('hospitals', 'PatientController@showHospitals');
        Route::get('hospital/{hospital}', 'PatientController@showHospital');
        Route::get('laboratories', 'PatientController@showLaboratories');
        Route::get('laboratory/{laboratory}', 'PatientController@showLaboratory');
        Route::get('pharmacies', 'PatientController@showPharmacies');
        Route::get('pharmacy/{pharmacy}', 'PatientController@showPharmacy');
        Route::get('medical-centers', 'PatientController@showMedicalCenter');

        Route::get('profile/shares', 'ProfileShareController@index');
        Route::get('notifications', 'NotificationController@showNotification')->name('patient.notification');
        Route::get('notification/unread', 'NotificationController@unreadNotification')->name('patient.unread.notification');
        Route::get('notification/read/{id}', 'NotificationController@readNotification')->name('patient.read.notification');
        Route::get('notification/delete/{id}', 'NotificationController@deleteNotification')->name('patient.delete.notification');
        Route::post('profile/shares', 'ProfileShareController@store')->name('patient.profile.share');
        Route::patch('profile/shares/{profileShare}/expire', 'ProfileShareController@expire');
        Route::patch('profile/shares/{profileShare}/extend', 'ProfileShareController@extend');
        Route::get('profile/shares/pending', 'ProfileShareController@pending');
        Route::patch('profile/shares/{profileShare}/accept', 'ProfileShareController@accept');
        Route::patch('profile/shares/{profileShare}/decline', 'ProfileShareController@decline');

        Route::post('doctors', 'PatientController@showDoctor')->name('patient.doctors.show');
        Route::get('contacts', 'ContactController@index');
        Route::post('contacts', 'ContactController@store');
        Route::delete('contacts/{contact}', 'ContactController@delete');
    });

    Route::group(['prefix' => 'laboratories', 'namespace' => 'Laboratory', 'middleware' => ['api', 'auth:laboratory-api']], function () {
        Route::get('/profile', 'LaboratoryController@index');
        Route::patch('profile/update', 'LaboratoryController@update');
        Route::post('/profile/update/image', 'LaboratoryController@updateAvatar');

        Route::get('patients', 'ProfileShareController@index');
        Route::get('patients/pending', 'ProfileShareController@pending');
        Route::get('patients/{patient}/records', 'MedicalRecordController@index');
        Route::get('patients/{patient}/records/{medicalRecord}', 'MedicalRecordController@show');
        Route::post('patients/{patient}/records/{medicalRecord}/{labTest}', 'MedicalRecordController@testrecord');
        Route::patch('patients/pending/{profileShare}/accept', 'ProfileShareController@accept')->name('laboratory.accept.patient');
        Route::patch('patients/pending/{profileShare}/decline', 'ProfileShareController@decline')->name('laboratory.decline.patient');
        Route::get('notifications', 'NotificationController@showNotification')->name('laboratory.notification');
        Route::get('notification/read/{id}', 'NotificationController@readNotification')->name('laboratory.read.notification');
        Route::get('notification/unread', 'NotificationController@unreadNotification')->name('laboratory.unread.notification');
        Route::get('notification/delete/{id}', 'NotificationController@deleteNotification')->name('laboratory.delete.notification');
    });

    Route::group(['prefix' => 'hospital', 'namespace' => 'Hospital', 'middleware' => ['api', 'auth:hospital-api']], function () {
        Route::get('profile', 'ProfileController@index');
        Route::patch('profile', 'ProfileController@update');
        Route::get('patients', 'PatientController@index');
        Route::get('patients/pending', 'ProfileShareController@pending');
        Route::post('patients/{profileShare}/assign', 'PatientController@assignMultiple');
        Route::delete('patients/{profileShare}/unassign/{doctor}', 'PatientController@unassign');
        Route::patch('patients/pending/{profileShare}/accept', 'ProfileShareController@accept')->name('hospital.profile.accept');
        Route::patch('patients/pending/{profileShare}/decline', 'ProfileShareController@decline');
        // Route::patch('patients/{profileShare}/assign/{doctor}', 'PatientController@assign');
        Route::get('patients/{patient}/records', 'MedicalRecordController@index');
        Route::get('patients/{patient}/records/{medicalRecord}', 'MedicalRecordController@show');

        Route::get('doctors', 'DoctorController@index');
        Route::get('doctors/pending', 'DoctorController@pending');
        Route::get('doctors/sent', 'DoctorController@sent');
        Route::post('doctors/{doctor}/invite', 'DoctorController@invite');
        Route::patch('doctors/{doctor}/accept', 'DoctorController@accept');
        Route::patch('doctors/{doctor}/decline', 'DoctorController@decline');
        Route::delete('doctors/{doctor}/delete', 'DoctorController@remove');
        Route::get('notifications', 'NotificationController@showNotification')->name('hospital.notification');
        Route::get('notification/read/{id}', 'NotificationController@readNotification')->name('hospital.read.notification');
        Route::get('notification/unread', 'NotificationController@unreadNotification')->name('hospital.unread.notification');
        Route::get('notification/delete/{id}', 'NotificationController@deleteNotification')->name('hospital.delete.notification');
    });

    Route::group(['prefix' => 'pharmacy', 'namespace' => 'Pharmacy', 'middleware' => []], function () {
        Route::get('profile', 'ProfileController@index');
        Route::patch('profile', 'ProfileController@update');
        Route::get('patients', 'PatientController@index');
        Route::get('patients/pending', 'ProfileShareController@pending');
        Route::patch('patients/pending/{profileShare}/accept', 'ProfileShareController@accept')->name('pharmacy.profile.accept');
        Route::patch('patients/pending/{profileShare}/decline', 'ProfileShareController@decline');
        Route::get('patients/{patient}/records', 'MedicalRecordController@index');
        Route::get('patients/{patient}/records/{medicalRecord}', 'MedicalRecordController@show');
        Route::patch('patients/{patient}/records/{medicalRecord}/{prescription}', 'MedicalRecordController@dispense');
        Route::get('notifications', 'NotificationController@showNotification')->name('pharmacy.notification');
        Route::get('notification/read/{id}', 'NotificationController@readNotification')->name('pharmacy.read.notification');
        Route::get('notification/unread', 'NotificationController@unreadNotification')->name('pharmacy.unread.notification');
        Route::get('notification/delete/{id}', 'NotificationController@deleteNotification')->name('pharmacy.delete.notification');
    });
});
