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

**PATCH /doctor/update** [ Doctor Updates his profile ]

| Attribute | Type | Required | Description |
| --------- | ---- | -------- | ----------- |
|`address`|string| true | Doctor address|
|`city`|string|true|Doctor City|
|`state`|string|true|Doctor state|
|`country`|string|true|Doctor country|
|`mode_of_contact`|boolean|true|Doctor mode of contact sms or phone|
|`marital_status`|string|true|Doctor marital status|
|`religion`|string|true|Doctor religion|
|`kin_fullname`|string|true|Doctor Kin Full name|
|`kin_address`|string|true|Doctor Kin Address|
|`kin_phone`|string|true|Doctor Kin Full Phone number|
|`kin_city`|string|true|Doctor Kin City|
|`kin_state`|string|true|Doctor Kin State|
|`kin_country`|string|true|Doctor Kin Country|
|`name_of_degree`|string|true|Doctor Degree nam|
|`institution`|string|true|Doctor Institution|
|`additional_degree`|string|true|Doctor Additional Degree|
|`years_in_practice`|integer|true|Doctor practice years|
|`avatar`|string|true|Doctor Image|

 **PATCH \doctor\{hospital}\accept-hospital** [ Doctor Accepts Hospitals ]

 **PATCH \doctor\{hospital}\accept-hospital** [ Doctor Declines Hospitals ]

 **PATCH \doctor\{hospital}\remove-hospital** [ Doctor Removes Hospitals]

 **PATCH \doctor\patients\pending\{profileShare}\accept** [Doctor Accepts Patient]

 **PATCH \doctor\patients\pending\{profileShare}\decline** [Doctor Declines Patient]



## Doctors API Endpoints Get Methods

**GET \doctor\profile**

| Attribute | Type | Required | Description |
| --------- | ---- | -------- | ----------- |
|`address`|string| true | Doctor address|
|`city`|string|true|Doctor City|
|`state`|string|true|Doctor state|
|`country`|string|true|Doctor country|
|`mode_of_contact`|boolean|true|Doctor mode of contact sms or phone|
|`marital_status`|string|true|Doctor marital status|
|`religion`|string|true|Doctor religion|
|`kin_fullname`|string|true|Doctor Kin Full name|
|`kin_address`|string|true|Doctor Kin Address|
|`kin_phone`|string|true|Doctor Kin Full Phone number|
|`kin_city`|string|true|Doctor Kin City|
|`kin_state`|string|true|Doctor Kin State|
|`kin_country`|string|true|Doctor Kin Country|
|`name_of_degree`|string|true|Doctor Degree nam|
|`institution`|string|true|Doctor Institution|
|`additional_degree`|string|true|Doctor Additional Degree|
|`years_in_practice`|integer|true|Doctor practice years|
|`avatar`|string|true|Doctor Image|
|`disablity`|string|true|Doctor Disability|

**GET \doctor\hospital** [Doctors Hospitals]

**GET \doctor\active-hospital** [Doctors Active Hospitals]

**GET \doctor\pending-hospital** [Doctors Pending Hospitals]

**GET \doctor\sent-hospital** [Doctors sent Hospitals]


**GET \doctor\patients**  [Doctors Patients]

**GET \doctor\patients\{patient}\** [Doctors views one Patient]
**GET \doctor\patients\pending\patients** [Doctors views pending Patients]




## Doctors API Endpoints Delete Methods
- **Doctor Deletes Notification (https://domain.com/doctor/notification/{id}) route('doctor.notification.read')**

## Laboratory API EndPoint (Basics Data)

| Attribute | Type | Required | Description |
| --------- | ---- | -------- | ----------- |
|`name`|string| true | laboratory name|
|`email`|string| true | email|
|`password`|string| true | password|
|`phone`|string| true | phone number|
|`address`|string| true | adddress|
|`city`|string| true | city|
|`state`|string| true | state|
|`country`|string| true | country|
|`avatar`|string|null | avatar|

- **POST \admin\laboratory** [should be able to laboratory] 




- **GET \admin\laborartory** [Admin show get all registered laboratory]
- **GET \admin\labratory\{laboratory}** [admin get retrieve a particular laboratory with chcode]




- **PATCH \laboratories\{laboratory}**  [admin can update laboratory information]
- **PATCH \laboratories\deactivate\{laboratory}**  [admin deactive an active laboratory]


- **DELETE \laboratories\{laboratory}** [admin delete laboratory]


## LabTest API Endpoint (Lab Medical Records Usage)
| Attribute | Type | Required | Description |
| --------- | ---- | -------- | ----------- |
|`test_name`|string|true|name of test|
|`description`|text|true|test description|
|`conclusion`|text|true|findings after test|
|`status`|boolean|false|status of test|
|`taker`|string|true|consultant name|

- **GET \Laboratories** [Laboratory View Home Page]
- **GET \Laboratories\patient** [Recieve Patient Profile share]
- **GET \Laboratories\patient\pending** [pending profile share]
- **GET \Laboratories\patient\{patient}\records** [View Medical record]
- **GET \Laboratories\patient\{patient}\records?start_date={startDate}** [Filter medical Record by start date]
- **GET \Laboratories\patient\{patient}\records?start_date={endDate}** [Filter medical record by end date]
- **GET \Laboratories\patient\{patient}\records\{records}** [get patient medical record]

- **PATCH \Laboratories\{laboratories}\laboratories** [Update Profile share ]
- **PATCH \Laboratories\patient\{patient}\records\{records}\{labtestRecord}** [Update Lab records ]
- **PATCH \Laboratories\patient\{profileShare}\accept** [accept patient profile share]
- **PATCH \Laboratories\patient\{profileShare}\decline** [decline profile share]

## Patient API EndPoint (Admin ViewPoint)

- **GET /api/admin/patients** [admin view all patient with pagination]
- **GET /api/admin/patients/{patient}** [admin can view a singular thread of a patient]


- **POST /api/admin/patients** [admin can signup a new user]



- **PATCH /api/admin/patients/{patient}/patients** [Admin can update patient information]

- **PATCH /api/admin/patients/deactivate/{patient}** [Admin can deactivate a patient]



- **DELETE /api/admin/patients/{patient}** [admin can delete patient info]


## Patient API EndPopint (Patient View Point)

- **GET api/patient/{patient}/patient** [Patient can view his basic info]
- **GET api/patient/medical-record/{patient}**  [Patient Medical Record by date]
- **GET api/patient/{patient}/labtest**  [Patient Labtest]
- **GET api/patient/{patient}/prescription** [Patient Pharmacy record or labtest]
- **GET api/patient/{patient}/medical-records** [Medical record of a Patient]




- **POST api/patient/register** [Patient signup from clean helt]


- **PATCH api/patient/{patient}/patient** [Patient can Update his profile]
