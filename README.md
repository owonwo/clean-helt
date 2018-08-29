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




## Laboratory API EndPoint (Basics Data)


- **POST api\admin\laboratory** [should be able to laboratory] 




- **GET api\admin\laborartory** [Admin show get all registered laboratory]

- **GET api\admin\labratory\{laboratory}** [admin get retrieve a particular laboratory with chcode]




- **PATCH api\laboratories\{laboratory}**  [admin can update laboratory information]

- **PATCH api\laboratories\deactivate\{laboratory}**  [admin deactive an active laboratory]


- **DELETE api\laboratories\{laboratory}** [admin delete laboratory]


## LabTest API Endpoint (Lab Medical Records Usage)

- **GET api/Laboratories** [Laboratory View Home Page]

- **GET api/Laboratories/patient** [Recieve Patient Profile share]

- **GET api\Laboratories\patient\pending** [pending profile share]

- **GET api\Laboratories\patient\{patient}\records** [View Medical record]

- **GET api\Laboratories\patient\{patient}\records?start_date={startDate}** [Filter medical Record by start date]

- **GET api\Laboratories\patient\{patient}\records?start_date={endDate}** [Filter medical record by end date]

- **GET api\Laboratories\patient\{patient}\records\{records}** [get patient medical record]

- **PATCH api\Laboratories\{laboratories}\laboratories** [Update Profile share ]

- **PATCH api\Laboratories\patient\{patient}\records\{records}\{labtestRecord}** [Update Lab records ]

- **PATCH api\Laboratories\patient\{profileShare}\accept** [accept patient profile share]

- **PATCH api\Laboratories\patient\{profileShare}\decline** [decline profile share]

## Patient API EndPoint (Admin ViewPoint)

- **GET api/admin/patients** [admin view all patient with pagination]

- **GET api/admin/patients/{patient}** [admin can view a singular thread of a patient]


- **POST api/admin/patients** [admin can signup a new user]



- **PATCH api/admin/patients/{patient}/patients** [Admin can update patient information]

- **PATCH api/admin/patients/deactivate/{patient}** [Admin can deactivate a patient]



- **DELETE /api/admin/patients/{patient}** [admin can delete patient info]


## Patient API EndPopint (Patient View Point)

- **GET api/patient/{patient}/patient** [Patient can view his basic info]

- **GET api/patient/medical-record/{patient}**  [Patient Medical Record by date]

- **GET api/patient/profile/shares**  [A patient can view log of his share profile]

- **GET api/patient/{patient}/labtest**  [Patient Labtest]

- **GET api/patient/{patient}/prescription** [Patient Pharmacy record or labtest]

- **GET api/patient/{patient}/medical-records** [Medical record of a Patient]




- **POST api/patient/register** [Patient signup from clean helt]

- **POST api/patient/profile/shares** [Patient share his profile base on date]




- **PATCH api/patient/{profileShare}/patient** [Patient can Update his profile]

- **PATCH api/patient/profile/shares/{shareOne}/expire**  [Patient can cancel share]

- **PATCH api/patient/profile/shares/{profileShare}/extend** [Patient can extend or add extra time]

