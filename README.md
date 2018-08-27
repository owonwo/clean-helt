<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Clean Helt 

Clean helt is a web applications that allow patients, hospitals, pharmacies, doctors and laboratries to communicate in sync


Clean helt software is only accessible to people who buy the clean helt application.

## Doctors API Endpoints Post Methods

**POST \doctor\create** [Create a doctor]

| Attribute | Type | Required | Description |
| --------- | ---- | -------- | ----------- |
|`first_name`|string| true | Doctors first name|
|`last_name`|string|true|Doctors Last name |
|`middle_name`|string|true|Doctors Middle name |
|`email`|email|true|Doctors Email |
|`password`|string|true|Doctors Login Password |
|`phone`|string|unique|Doctors Middle name |
|`gender`|string|true|Doctors Gender |
|`specialization`|string|true|Doctors Middle name |
|`folio`|string|true|Doctors Certification number |


**POST \doctor\add-hospital** [Doctor Adds a Hospital]

| Attribute | Type | Required | Description |
| --------- | ---- | -------- | ----------- |
|`chcode`|string| true | chcode of the hospital|
|`hospital_id`|id|true|Will be gotten from chcode |
|`doctor_id`|id|true|From doctor who sent request |


**POST \doctor\patients\{patient}\diagnose** [Doctor creates diagnosis]

| Attribute | Type | Required | Description |
| --------- | ---- | -------- | ----------- |
|`record_id`|string| true | chcode of the hospital|
|`complaint_history`|id|true|Will be gotten from chcode |
|`complaint_relationship`|id|true|From doctor who sent request |
|`patient_condition`|enum:1,2,3|true|Condition of the patient|
|`symptoms`|json|true|Illness symptoms for patient|
|`extras`|json|true|Extras for patient|
|`quantity`|integer|true|drug prescription quantity|
|`frequency`|integer|true|drug prescription frequency|
|`name`|string|true|drug name|
|`test_ name`|string|true|Name of test|
|`description`|string|true|Test description|
|`result`|string|true|Test result|
|`conclusion`|string|true|Test conclusion|
|`status`|boolean|true|Status of the Test|
|`taker`|id|true|The labroratory test owner|



## Doctors API Endpoints Patch Methods
- **Doctor Updates his profile (https://domain.com/doctor/update) route('doctor.update')**
- **Doctor Accepts Hospital (https://domain.com/doctor/{hospital}/accept-hospital) route           ('doctor.hospital.accept')**
- **Doctor Declines Hospital (https://domain.com/doctor/{hospital}/decline-hospital) route('doctor.hospital.decline')**
- **Doctor removes Hospital (https://domain.com/doctor/{hospital}/remove-hospital) route('doctor.hospital.remove') // model binder for hospital is chcode**
- **Doctor Accepts Patient (https://domain.com/doctor/patients/pending/{profileShare}/accept) route('doctor.accept.patient') // model binder for ProfileShare is chcode**
- **Doctor Declines Patient (https://domain.com/doctor/patients/pending/{profileShare}/decline) route('doctor.decline.patient') //model binder for ProfileShare is chcode**

## Doctors API Endpoints Get Methods
- **Doctor Register Form (https://domain.com/doctor/register/confirm) route('doctor.register.confirm')**
- **Doctor Profile (https://domain.com/doctor/profile) route('doctor.profile')**
- **Doctor Hospitals (https://domain.com/doctor/hospital) route('doctor.hospital')**
- **Doctor Active Hospitals (https://domain.com/doctor/active-hospitals) route('doctor.hospital.active')**
- **Doctor Pending Hospitals (https://domain.com/doctor/pending-hospitals) route('doctor.hospital.pending')**
- **Doctor sent Hospitals (https://domain.com/doctor/sent-hospitals) route('doctor.hospital.sent')**
- **Doctor All Patients (https://domain.com/doctor/patients) route('doctor.patients')**
- **Doctor Look on Patient (https://domain.com/doctor/patients/{patient}) route('doctor.patient')**
- **Doctor Pending Patient (https://domain.com/doctor/patients/pending/patients) route('doctor.pending.patient')**

## Doctors API Endpoints Delete Methods
- **Doctor Deletes Notification (https://domain.com/doctor/notification/{id}) route('doctor.notification.read')**

