## Hospital API Documentation

### Base URL

**`BASE URL: /api/hospital`**

### Profile Management

**`GET /profile`**

Returns an authenticated hospital's profile information.

Sample Response:

```json
    {
      "message":"Hospital retrieved successfully",
      "hospital": {
          "id":1,
          "name":"New Era Hospital",
          "email":"kelley20@example.com",
          "chcode":"CHH293415609",
          "director_mdcn":"natus",
          "phone":"252-582-5657 x62181",
          "address":"673 Niko Corner Apt. 054\nVivianneville, IA 48169",
          "city":"Luisfurt",
          "state":"Hodkiewiczview",
          "country":"Mongolia",
          "website":null,
          "facility_type":null,
          "facility_owner":null,
          "cac_reg":null,
          "cac_date":null,
          "fmoh_reg":null,
          "fmoh_date":null,
          "admin_name":null,
          "admin_position":null,
          "admin_phone":null,
          "services":null,
          "bank_name":null,
          "bank_branch":null,
          "account_name":null,
          "account_number":null,
          "active":1,
          "avatar":"avatar/avatar.jpeg",
          "remember_token":null,
          "created_at":"2018-09-03 20:16:47",
          "updated_at":"2018-09-03 21:57:02",
          "deleted_at":null
      }
    }
```

**`PATCH /profile`**

Updates an authenticated hospital's profile information.

Sample Data:

```json
{
  "name": "New Value"
} 
```

Sample Response:

```json
    {
      "message":"Profile updated successfully",
      "hospital": {
          "id":1,
          "name":"New Era Hospital",
          "email":"kelley20@example.com",
          "chcode":"CHH293415609",
          "director_mdcn":"natus",
          "phone":"252-582-5657 x62181",
          "address":"673 Niko Corner Apt. 054\nVivianneville, IA 48169",
          "city":"Luisfurt",
          "state":"Hodkiewiczview",
          "country":"Mongolia",
          "website":null,
          "facility_type":null,
          "facility_owner":null,
          "cac_reg":null,
          "cac_date":null,
          "fmoh_reg":null,
          "fmoh_date":null,
          "admin_name":null,
          "admin_position":null,
          "admin_phone":null,
          "services":null,
          "bank_name":null,
          "bank_branch":null,
          "account_name":null,
          "account_number":null,
          "active":1,
          "avatar":"avatar/avatar.jpeg",
          "remember_token":null,
          "created_at":"2018-09-03 20:16:47",
          "updated_at":"2018-09-03 21:57:02",
          "deleted_at":null
      }
    }
```
<br/>

### Patient Management

**`GET /patients`**

Returns a list of patients a hospital has.

Sample Response:

```json
{
    "message": "Patients retrieved successfully",
    "patients": [
          {
              "id": 1,
              "patient_id": 1,
              "provider_type": "App\\Models\\Hospital",
              "provider_id": 1,
              "expired_at": "2018-10-01 00:00:00",
              "doctor_id": null,
              "status": "0",
              "created_at": null,
              "updated_at": null,
              "patient": {
                  "id": 1,
                  "first_name": "Maxie",
                  "middle_name": "Eichmann",
                  "last_name": "Steuber",
                  "chcode": "CHP306622590",
                  "avatar": "avatar/avatar.jpeg",
                  "email": "lueilwitz.dominique@example.net",
                  "dob": "1995-07-14",
                  "gender": "male",
                  "phone": "+1 (304) 626-6064",
                  "address": "851 Wisozk Ramp Apt. 896\nJamilborough, MA 44522-9404",
                  "city": "Faheytown",
                  "state": "Terrymouth",
                  "country": "Kuwait",
                  "active": 1,
                  "religion": "Muslim",
                  "marital_status": "divorced",
                  "token": null,
                  "nok_name": "Vince Nikolaus DVM",
                  "nok_phone": "1-803-705-2897 x7807",
                  "nok_email": "ansel.waters@example.org",
                  "nok_address": "29467 Caitlyn Parkways Suite 574\nStoltenbergside, LA 88441",
                  "nok_city": "Dietrichstad",
                  "nok_state": "East Payton",
                  "verify_token": null,
                  "status": 0,
                  "nok_country": null,
                  "remember_token": null,
                  "created_at": "2018-09-03 20:16:47",
                  "updated_at": "2018-09-03 20:16:47"
              }
          }
    ]
}
```
<br/>

**`GET patients/{patient}/records`** 

```
{patient} => patient's chcode
```

Returns a list of a patients records.

Request Modifiers (Search Params)
```
type: [prescriptions|diagnosis|tests]
start_date: [YYYY-mm-dd]
end_date: [YYYY-mm-dd]
```

Sample Response
```json
{
    "records": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "reference": "CHR532109131",
                "patient_id": 1,
                "type": "App\\Models\\LabTest",
                "issuer_type": "App\\Models\\Doctor",
                "issuer_id": 12,
                "created_at": "2018-09-03 20:16:47",
                "updated_at": "2018-09-03 20:16:47",
                "deleted_at": null
            }
        ],
        "first_page_url": "http://clean-helt-api.test/api/hospital/patients/CHP306622590/records?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://clean-helt-api.test/api/hospital/patients/CHP306622590/records?page=1",
        "next_page_url": null,
        "path": "http://clean-helt-api.test/api/hospital/patients/CHP306622590/records",
        "per_page": 30,
        "prev_page_url": null,
        "to": 1,
        "total": 1
    }
}
```
<br/>

**`GET patients/{patient}/records/{medicalRecord}`**

```
{patient} => patient's chcode
{medicalRecord} => record's reference
```

Returns the details of a medical record.

Sample Response:
```json
{
    "data": {
        "id": 1,
        "reference": "CHR532109131",
        "patient_id": 1,
        "type": "App\\Models\\LabTest",
        "issuer_type": "App\\Models\\Doctor",
        "issuer_id": 12,
        "created_at": "2018-09-03 20:16:47",
        "updated_at": "2018-09-03 20:16:47",
        "deleted_at": null,
        "data": [
            {
                "id": 1,
                "record_id": 1,
                "test_name": "Larue O'Hara",
                "description": "Soluta aspernatur quam exercitationem sed. Iste quasi ex labore beatae modi adipisci sit voluptatibus. Ipsam placeat rerum minus vitae voluptatem ex reiciendis. Odio consequatur magni debitis voluptas aut porro.",
                "result": "Suscipit et autem quis temporibus doloribus. Laudantium consectetur alias et aut rerum harum saepe. Ut ullam necessitatibus praesentium impedit vel pariatur.",
                "conclusion": "Aut reiciendis blanditiis dolorem veniam sit fuga error. Dicta aut incidunt delectus aut dolorum quisquam. Labore cum minima alias quia facilis.",
                "status": 1,
                "taker": "1",
                "diagnosis_id": 1,
                "created_at": "2018-09-03 20:16:47",
                "updated_at": "2018-09-03 20:16:47"
            }
        ]
    }
}
```
<br/>

**`GET /patients/pending`**

Returns a list of pending patients (profile shares) a hospital has.

Sample Response:

```json
{
  "message":"Patients retrieved successfully",
  "patients": [
      {
          "id": 1,
          "patient_id": 1,
          "provider_type": "App\\Models\\Hospital",
          "provider_id": 1,
          "expired_at": "2018-10-01 00:00:00",
          "doctor_id": null,
          "status": "0",
          "created_at": null,
          "updated_at": null,
          "patient": {
              "id": 1,
              "first_name": "Maxie",
              "middle_name": "Eichmann",
              "last_name": "Steuber",
              "chcode": "CHP306622590",
              "avatar": "avatar/avatar.jpeg",
              "email": "lueilwitz.dominique@example.net",
              "dob": "1995-07-14",
              "gender": "male",
              "phone": "+1 (304) 626-6064",
              "address": "851 Wisozk Ramp Apt. 896\nJamilborough, MA 44522-9404",
              "city": "Faheytown",
              "state": "Terrymouth",
              "country": "Kuwait",
              "active": 1,
              "religion": "Muslim",
              "marital_status": "divorced",
              "token": null,
              "nok_name": "Vince Nikolaus DVM",
              "nok_phone": "1-803-705-2897 x7807",
              "nok_email": "ansel.waters@example.org",
              "nok_address": "29467 Caitlyn Parkways Suite 574\nStoltenbergside, LA 88441",
              "nok_city": "Dietrichstad",
              "nok_state": "East Payton",
              "verify_token": null,
              "status": 0,
              "nok_country": null,
              "remember_token": null,
              "created_at": "2018-09-03 20:16:47",
              "updated_at": "2018-09-03 20:16:47"
          }
      }
  ]
}
```

**`PATCH /patients/pending/{profileShare}/accept`**

```
{profileShare} => ProfileShare id
```

Accepts a prospective patients profile share.

Sample Data:

```json
{}
```

Sample Response:

```json
{
    "message": "Profile share accepted successfully",
    "share": {
        "id": 1,
        "patient_id": 1,
        "provider_type": "App\\Models\\Hospital",
        "provider_id": 1,
        "expired_at": "2018-10-01 00:00:00",
        "doctor_id": null,
        "status": 1,
        "created_at": null,
        "updated_at": null
    }
}
```
<br/>

**`PATCH /patients/pending/{profileShare}/decline`**

```
{profileShare} => ProfileShare id
```

Declines a prospective patients profile share.

Sample Data:

```json
{}
```

Sample Response:

```json
{
    "message": "Profile share declined successfully",
    "share": {
        "id": 1,
        "patient_id": 1,
        "provider_type": "App\\Models\\Hospital",
        "provider_id": 1,
        "expired_at": "2018-10-01 00:00:00",
        "doctor_id": null,
        "status": 2,
        "created_at": null,
        "updated_at": null
    }
}
```
<br/>

**`PATCH /patients/{profileShare}/assign/{doctor}`**

```
{profileShare} => Profile Share id
{doctor} => Doctor's chcode
```

Assigns a patients profile share to a doctor

Sample Data:

```json
{}
```

Sample Response:

```json
{
    "message": "Patient assigned to doctor successfully"
}
```

### Doctor Management

**`GET /doctors`**

Returns a list of doctors that work in the hospital.

Sample Response:

```json
{
   "message": "Doctors retrieved successfully",
   "doctors": [
      {
          "id": 1,
          "first_name": "Marcel",
          "middle_name": "Hagenes",
          "last_name": "Haag",
          "email": "dessie.conrey@gmail.com",
          "phone": "623-214-6007 x28574",
          "gender": "female",
          "specialization": "cardiologist",
          "folio":"MB/12/7d",
          "confirm": false,
          "validation": 0,
          "chcode": "CHD984092751",
          "token": "i74U2gPLhVVigDGXnYSWRL30BLAb9TnZ8cbO7sQu",
          "remember_token": null,
          "deleted_at": null,
          "created_at": "2018-09-03 20:16:47",
          "updated_at": "2018-09-03 20:16:47",
          "pivot": {
             "hospital_id": 1,
             "doctor_id": 1
          }
      }
   ]
}
```
<br/>

**`GET /doctors/pending`**

Returns a list of pending doctors - doctors who have indicated they work in a hospital but have not been accepted.

Sample Response:

```json
{
   "message": "Doctors retrieved successfully",
   "doctors": [
      {
          "id": 1,
          "first_name": "Marcel",
          "middle_name": "Hagenes",
          "last_name": "Haag",
          "email": "dessie.conrey@gmail.com",
          "phone": "623-214-6007 x28574",
          "gender": "female",
          "specialization": "cardiologist",
          "folio":"MB/12/7d",
          "confirm": false,
          "validation": 0,
          "chcode": "CHD984092751",
          "token": "i74U2gPLhVVigDGXnYSWRL30BLAb9TnZ8cbO7sQu",
          "remember_token": null,
          "deleted_at": null,
          "created_at": "2018-09-03 20:16:47",
          "updated_at": "2018-09-03 20:16:47",
          "pivot": {
             "hospital_id": 1,
             "doctor_id": 1
          }
      }
   ]
}
```
<br/>

**`GET /doctors/sent`**

Returns a list of doctors the hospital has sent an invite to but have not been accepted.

Sample Response:

```json
{
   "message": "Doctors retrieved successfully",
   "doctors": [
      {
          "id": 1,
          "first_name": "Marcel",
          "middle_name": "Hagenes",
          "last_name": "Haag",
          "email": "dessie.conrey@gmail.com",
          "phone": "623-214-6007 x28574",
          "gender": "female",
          "specialization": "cardiologist",
          "folio":"MB/12/7d",
          "confirm": false,
          "validation": 0,
          "chcode": "CHD984092751",
          "token": "i74U2gPLhVVigDGXnYSWRL30BLAb9TnZ8cbO7sQu",
          "remember_token": null,
          "deleted_at": null,
          "created_at": "2018-09-03 20:16:47",
          "updated_at": "2018-09-03 20:16:47",
          "pivot": {
             "hospital_id": 1,
             "doctor_id": 1
          }
      }
   ]
}
```
<br/>

**`POST /doctors/{doctor}/invite`**

```
{doctor} => Doctor's chcode
```

Invites a doctor to confirm he works in a hospital.

Sample Data: 

```json
{}
```

Sample Response:

```json
{
   "message": "Doctor invite sent successfully"
}
```
<br/>

**`PATCH /doctors/{doctor}/accept`**

```
{doctor} => Doctor's chcode
```

Confirms a doctor works in a hospital.

Sample Data: 

```json
{}
```

Sample Response:

```json
{
   "message": "Doctor approved successfully"
}
```
<br/>

**`PATCH /doctors/{doctor}/decline`**

```
{doctor} => Doctor's chcode
```

Declines a doctor works in a hospital.

Sample Data: 

```json
{}
```

Sample Response:

```json
{
   "message": "Doctor declined successfully"
}
```
<br/>

**`DELETE /doctors/{doctor}/delete`**

```
{doctor} => Doctor's chcode
```

Detaches a doctor from a hospital.

Sample Response:

```json
{
   "message": "Doctor removed successfully"
}
```
<br/>