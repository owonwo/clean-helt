<p align="center"><img src="/logo.png"></p>

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
- **Doctor Login (https://domain.com/doctor/create) route('doctor.create')**
- **Doctor Adds Hospital (https://domain.com/doctor/add-hospital) route('doctor.addHospital')**
- **Doctor Creates Diagnosis For Patient (https://domain.com/doctor/patients/{patient}/diagnose)**

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

