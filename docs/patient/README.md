##               API DOCUMENTATION FOR PATIENTS
### PATIENT SIGNUP/REGISTRATION

**`POST api/patient/register`**

Sample Data
```json
{
  "email": "email@email.com",
  "first_name": "name",
  "last_name": "name",
  "phone": "12345678901",
  "password": "secret"
}
```
Response 

```json
{
    "message": "Congratulation! you have successfully created patient record",
    "patients": {
        "email": "example@exam.com",
        "first_name": "abigirl",
        "last_name": "prince_wara",
        "phone": "1234567890",
        "verify_token": "rZJSzFsWTiqhM1rHFYHZb444Me7bNV5JtUJSFOSh",
        "token": "I5Xau6fhGJlQ4imSBUyDAfEBhiDGcA4SwUZdfyKy",
        "chcode": "CHP654711621",
        "updated_at": "2018-09-06 08:32:58",
        "created_at": "2018-09-06 08:32:58",
        "id": 82
    },
    "accessToken": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImIxYjM5Nzg4MjI0MzEyMWI5ZjBmMzNlYjI3YjhhZjRiMmY4OTJmMTBhZWM5OWNlYjUwNzFlMjllZGI5NzNmOTc2M2I3MmFlNDA2OTQ5NTM0In0.eyJhdWQiOiIxIiwianRpIjoiYjFiMzk3ODgyMjQzMTIxYjlmMGYzM2ViMjdiOGFmNGIyZjg5MmYxMGFlYzk5Y2ViNTA3MWUyOWVkYjk3M2Y5NzYzYjcyYWU0MDY5NDk1MzQiLCJpYXQiOjE1MzYyMjI3NzksIm5iZiI6MTUzNjIyMjc3OSwiZXhwIjoxNTY3NzU4Nzc5LCJzdWIiOiI4MiIsInNjb3BlcyI6W119.WyDzLmUbd8YGJ6rIHeY3ZP7mw_NERDHiM9inJOEneoEcZrZeiYcBouo_r57Efw7W0QYdcIdpnN0IQ69Bp9FFGTj-8wsWyYQM4HhVg01pfXuIQeCPyw8z3MINLyROIprYwckCG7L-vDsL7a5XXeWf7JIychTE1KB3P3cD0h_k6m1JpwVvoplicHxHi4Yijzapi5xy5qNfT0WojjtkzGIBCRzwABkFHLEcOkI2uY73ZPcsuayfMEogXdwoAzfT4BASSwUcj7X3lh3fdKgiWPlBDvKJjhWG5jXijk92xkts6rnK0WjYX2O-oNJH9Y3Z0nia1l9pom3A-y7w7nOx__BTxoHWkJZsagfGXH4flGzkaZjCBk_GXIMwkf33vy99gdVWhtBZ5GZAHhG0AZNXAfrPcnM7f3zHtNMTE8TNcRqcfg03DdhP-1s4Fodkeb0B21p_P3pN0PwgBtiqDOOWYvcEoQTO22gdqES0iAWj5NACq9_Q46v2h16ftnHaPH5NQKe2wPJqW9ARXaMuqg49Kptb17w1tleBub-CMTH9tyMSXZg_JKYP7Tv0J1G0TqatAg7fEiyhi8wtp9R21WwLij7iW6KB5z2zLsDI6obF4Qa0ikgogkpzGtyr7Aq6K8BEWmhhWJlqPZ4YQwSLyiagak3hbidqZue0rEve8tRlY4SwrWM"
}
```
<br>


### Email confirmation

**`GET api/patient/verify/{email}/{verifyToken}`**
```
email = useremail@gmail.com
verifyToken = vbjcdbcibbidsj94589034ujfj04
```

After registration a redirect to confirm account through email and then return


```json
{
message: "Congratulation you have just verified you account, login to continue",
patient: {
    id: 82,
    first_name: "abigirl",
    middle_name: null,
    last_name: "prince_wara",
    chcode: "CHP654711621",
    avatar: null,
    email: "example@exam.com",
    dob: null,
    gender: "other",
    phone: "1234567890",
    address: null,
    city: null,
    state: null,
    country: null,
    active: 1,
    religion: null,
    marital_status: null,
    token: "I5Xau6fhGJlQ4imSBUyDAfEBhiDGcA4SwUZdfyKy",
    nok_name: null,
    nok_phone: null,
    nok_email: null,
    nok_address: null,
    nok_city: null,
    nok_state: null,
    emergency_hospital_address: null,
    emergency_hospital_name: null,
    verify_token: null,
    status: 1,
    nok_country: null,
    remember_token: null,
    created_at: "2018-09-06 08:32:58",
    updated_at: "2018-09-06 08:41:27"
    }
}
```

### Patient Log In

**`POST api/login/patient`**

Sample Data
```json
{
  "email": "email@email.com",
  "password": "secret"
}
```
Response 


```json
{
    "user": {
        "id": 82,
        "first_name": "abigirl",
        "middle_name": null,
        "last_name": "prince_wara",
        "chcode": "CHP654711621",
        "avatar": null,
        "email": "example@exam.com",
        "dob": null,
        "gender": "other",
        "phone": "1234567890",
        "address": null,
        "city": null,
        "state": null,
        "country": null,
        "active": 1,
        "religion": null,
        "marital_status": null,
        "token": "I5Xau6fhGJlQ4imSBUyDAfEBhiDGcA4SwUZdfyKy",
        "nok_name": null,
        "nok_phone": null,
        "nok_email": null,
        "nok_address": null,
        "nok_city": null,
        "nok_state": null,
        "emergency_hospital_address": null,
        "emergency_hospital_name": null,
        "verify_token": null,
        "status": 1,
        "nok_country": null,
        "remember_token": null,
        "created_at": "2018-09-06 08:32:58",
        "updated_at": "2018-09-06 08:41:27"
    },
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjIyMTY3MzE2M2YxNzM1OTZkMDMwYmUwMmZiMTc1YTYwMWY5NjZiOTE2Y2ZmMDM0MzRjYjJiNzlmOTFlODg3YTZhMTgxYTQzNDE3NWUzMjQ3In0.eyJhdWQiOiIxIiwianRpIjoiMjIxNjczMTYzZjE3MzU5NmQwMzBiZTAyZmIxNzVhNjAxZjk2NmI5MTZjZmYwMzQzNGNiMmI3OWY5MWU4ODdhNmExODFhNDM0MTc1ZTMyNDciLCJpYXQiOjE1MzYyMjcwMTQsIm5iZiI6MTUzNjIyNzAxNCwiZXhwIjoxNTY3NzYzMDE0LCJzdWIiOiI4MiIsInNjb3BlcyI6W119.XpCvhyOiFg9S03fHQ-9RXQ8HO-Eq7pxrMWR_uH6OmaPRzAKtMfq0TKE4xuglJRKryqjDVjd14TIF6FD02r8Q8E5lgX-EkfF23E172GnY4_AbdcwhNqeMpuDhkYTBJRH9HeOQwEzNrTguaSatkfQdUKPtI2klCJZy4QBG-o2Vvmi5NQkBeI2xzghV3uV9KPZC6wXGQwm6-ms11Q482d2tPuI2dL02iUA9q1FmEbkj_lKg4-cwtNlZXAU5LsT_mqz6H6n0uSIauyzeiKaFqftsM7_tZ96xCG59zesJNP24hZNICfQpJ420HlgX8qC4xdaosIM14oJ4fZBjxVKQoA4XGlyhlsmfsKrJObQzdKVcM-2BRR1L6S--fdFov-AWiuh6fpCWA0jLWxKYZtEcNkgfJtOwAQKN21ib29IixWLoBA1MaIRQkKmNMiZaPBleu2J1z719qlTvebnzJ-qVEgoOeTIA6d4VgEzogcEVMhHJ2QgwDPz856A1ZuSQRhBcKhn_T1WZBooJfzyzu7NpwUyNigQ8wql-DOBnzzHNB3iWqRQmcPjXRULRvcYArgFWCxpV7Cei60Cy7GD7bsqymzq4ISvM56P5kTxxaLgWKaLG5z37z2Kk0ItXrdJAXA8HPsjDAkTWi5C2joQzdEj2bHytKKdPiCMMcSRQoPWnqHjIU3Q",
    "expires_in": 21600
}
```
<br>

### View Patient Page 

**`GET api/patient/profile`**

```json
{
    "message": "you have successfully log into your account",
    "patient": {
        "id": 82,
        "first_name": "abigirl",
        "middle_name": null,
        "last_name": "prince_wara",
        "chcode": "CHP654711621",
        "avatar": null,
        "email": "example@exam.com",
        "dob": null,
        "gender": "other",
        "phone": "1234567890",
        "address": null,
        "city": null,
        "state": null,
        "country": null,
        "active": 1,
        "religion": null,
        "marital_status": null,
        "token": "I5Xau6fhGJlQ4imSBUyDAfEBhiDGcA4SwUZdfyKy",
        "nok_name": null,
        "nok_phone": null,
        "nok_email": null,
        "nok_address": null,
        "nok_city": null,
        "nok_state": null,
        "emergency_hospital_address": null,
        "emergency_hospital_name": null,
        "verify_token": null,
        "status": 1,
        "nok_country": null,
        "remember_token": null,
        "created_at": "2018-09-06 08:32:58",
        "updated_at": "2018-09-06 08:41:27"
    }
}
```
<br/>

## Medical Record view 
### Patient Medical Record by Date 


**`GET  api/patient/medical-record/{patient}`**
```
{patient} = chcode 
```

```json
{
    "message": "access medical record by date",
    "patient": [
        {
            "id": 2,
            "reference": "CHR750289728",
            "patient_id": 51,
            "type": "App\\Models\\Diagnosis",
            "issuer_type": "App\\Models\\Doctor",
            "issuer_id": 2,
            "created_at": "2018-09-05 13:41:35",
            "updated_at": "2018-09-05 13:41:35",
            "deleted_at": null,
            "data": []
        }
    ]
}
```

### Get The Patient Profile Share 

**`GET api/patient/profile/shares`**

```json
{
    "message": "Shares retrieved successfully",
    "shares": [
        {
            "id": 1,
            "patient_id": 51,
            "provider_type": "App\\Models\\Doctor",
            "provider_id": 61,
            "expired_at": "2018-09-06 00:00:00",
            "doctor_id": null,
            "status": "0",
            "created_at": "2018-09-05 15:38:59",
            "updated_at": "2018-09-05 15:39:00"
        },
        {
            "id": 2,
            "patient_id": 51,
            "provider_type": "App\\Models\\Doctor",
            "provider_id": 62,
            "expired_at": "2018-09-06 00:00:00",
            "doctor_id": null,
            "status": "0",
            "created_at": "2018-09-05 15:38:59",
            "updated_at": "2018-09-05 15:39:00"
        },
        {
            "id": 3,
            "patient_id": 51,
            "provider_type": "App\\Models\\Doctor",
            "provider_id": 63,
            "expired_at": "2018-09-06 00:00:00",
            "doctor_id": null,
            "status": "0",
            "created_at": "2018-09-05 15:38:59",
            "updated_at": "2018-09-05 15:39:00"
        },
        {
            "id": 11,
            "patient_id": 51,
            "provider_type": "App\\Models\\Doctor",
            "provider_id": 23,
            "expired_at": "2018-09-06 00:00:00",
            "doctor_id": null,
            "status": "0",
            "created_at": "2018-09-05 22:01:08",
            "updated_at": "2018-09-05 22:01:08"
        },
        {
            "id": 12,
            "patient_id": 51,
            "provider_type": "App\\Models\\Doctor",
            "provider_id": 23,
            "expired_at": "2018-09-06 00:00:00",
            "doctor_id": null,
            "status": "0",
            "created_at": "2018-09-05 22:01:47",
            "updated_at": "2018-09-05 22:01:47"
        },
        {
            "id": 13,
            "patient_id": 51,
            "provider_type": "App\\Models\\Doctor",
            "provider_id": 23,
            "expired_at": "2018-09-06 00:00:00",
            "doctor_id": null,
            "status": "0",
            "created_at": "2018-09-05 22:05:00",
            "updated_at": "2018-09-05 22:05:00"
        }
    ]
}
```

### Get all patient laboratory test

**`GET api/patient/{patient}/labtest`**

```json
{
    "message": "You can access all laboratory record here",
    "patient": [
        {
            "id": 8,
            "record_id": 51,
            "test_name": "Haven Batz",
            "description": "Ea mollitia est provident. Hic natus explicabo ducimus sed consequuntur maiores ut. Odio laudantium et minus quia harum.",
            "result": "Qui doloremque porro amet et. Occaecati officia animi unde autem tenetur adipisci expedita. Nobis quia accusantium pariatur voluptatem magnam quia. Quas est quo in dolorem dignissimos magni aut suscipit. Quis ut natus alias aut minus delectus.",
            "conclusion": "Vel veniam et debitis a eius rerum impedit dolore. Amet neque qui ut velit hic voluptas laborum. Architecto quis minus quae. Architecto sint voluptates quod quidem fugiat. Deleniti soluta doloremque non illo dignissimos error recusandae.",
            "status": 1,
            "taker": "8",
            "diagnosis_id": 8,
            "created_at": "2018-09-05 13:41:59",
            "updated_at": "2018-09-05 13:41:59"
        },
        {
            "id": 9,
            "record_id": 51,
            "test_name": "Jasen Hartmann",
            "description": "Dolorum officia voluptas impedit. Tempora sit distinctio accusantium. Magni reiciendis ut cum qui laboriosam vel quos. Similique et pariatur deleniti temporibus rerum autem.",
            "result": "Iure odio quod perferendis consequuntur impedit nostrum. Mollitia sunt vitae molestiae nam. Quo fugiat illo ut magni. Unde quo ducimus consequatur quas quos. Maxime modi molestiae hic distinctio ea.",
            "conclusion": "Voluptatum magnam incidunt libero aut quos. Quisquam in quae rerum quaerat.",
            "status": 1,
            "taker": "9",
            "diagnosis_id": 9,
            "created_at": "2018-09-05 13:41:59",
            "updated_at": "2018-09-05 13:41:59"
        },
        {
            "id": 10,
            "record_id": 51,
            "test_name": "Josephine Paucek",
            "description": "Non saepe nemo est quibusdam qui. Est voluptatem ullam unde nam consequatur sapiente. Accusamus facere nobis qui.",
            "result": "Placeat hic aut ad ut magni. Non velit ea eum non molestias et unde similique. Incidunt distinctio dolorem corporis voluptatum officia eum placeat.",
            "conclusion": "Assumenda ipsum error incidunt et. Architecto nulla consequatur assumenda ut. At quos quia iure laboriosam ad consequatur. Ipsa provident et accusamus delectus.",
            "status": 1,
            "taker": "10",
            "diagnosis_id": 10,
            "created_at": "2018-09-05 13:41:59",
            "updated_at": "2018-09-05 13:41:59"
        }
    ]
}
```

### Patient viewing prescription or pharmacy 

**`GET api/patient/{patient}/prescription`**

```
{patient} = chcode  
```

```json
{
    "message": "access medical record by date",
    "patient": [
        {
            "id": 9,
            "record_id": 51,
            "quantity": 2,
            "frequency": 4,
            "name": "MediumSpringGreen",
            "pharmacy_id": 9,
            "diagnosis_id": 19,
            "comment": "Veritatis voluptas laborum aspernatur architecto vel.",
            "status": 1,
            "created_at": "2018-09-05 13:43:47",
            "updated_at": "2018-09-05 13:43:47"
        },
        {
            "id": 10,
            "record_id": 51,
            "quantity": 9,
            "frequency": 3,
            "name": "Coral",
            "pharmacy_id": 10,
            "diagnosis_id": 20,
            "comment": "Vel dolor repellat autem.",
            "status": 1,
            "created_at": "2018-09-05 13:43:47",
            "updated_at": "2018-09-05 13:43:47"
        },
        {
            "id": 7,
            "record_id": 51,
            "quantity": 6,
            "frequency": 5,
            "name": "DodgerBlue",
            "pharmacy_id": 7,
            "diagnosis_id": 17,
            "comment": "Qui et ducimus tenetur cumque quidem consequatur.",
            "status": 1,
            "created_at": "2018-09-05 13:43:46",
            "updated_at": "2018-09-05 13:43:46"
        },
        {
            "id": 8,
            "record_id": 51,
            "quantity": 2,
            "frequency": 3,
            "name": "Orange",
            "pharmacy_id": 8,
            "diagnosis_id": 18,
            "comment": "Adipisci dolore autem voluptatum et.",
            "status": 0,
            "created_at": "2018-09-05 13:43:46",
            "updated_at": "2018-09-05 13:43:46"
        }
    ]
}
```
### Get medical record

**`GET api/patient/{patient}/medical-records`**

```
{patient} = chcode 
```

```json
{
    "message": "Medical records successfully Loaded",
    "records": [
        {
            "id": 2,
            "reference": "CHR750289728",
            "patient_id": 51,
            "type": "App\\Models\\Diagnosis",
            "issuer_type": "App\\Models\\Doctor",
            "issuer_id": 2,
            "created_at": "2018-09-05 13:41:35",
            "updated_at": "2018-09-05 13:41:35",
            "deleted_at": null,
            "data": []
        }
    ]
}
```

### Create Share Laboratory,Doctor,Patient,Pharmacy

**`POST api/patient/profile/shares`**

Sample Data(please attach a time ahead of now, or today)


Sample Data
```json
{
  "chcode": "CHD09876375",
  "expiration": "2018-09-07"
}
```
Response 

```json
{
    "message": "Profile shared successfully",
    "share": {
        "provider_type": "App\\Models\\Doctor",
        "provider_id": 23,
        "expired_at": "2018-09-07 00:00:00",
        "patient_id": 51,
        "updated_at": "2018-09-06 11:03:01",
        "created_at": "2018-09-06 11:03:01",
        "id": 17
    }
}
```

Patient Updating His Basic information

**`PATCH api/patient/profile/update`**

Scheme Data

```json
{
  "email": "email@email.com",
  "first_name": "jolly",
  "last_name": "jellof",
  "phone": "0980900889",
  "password": "secret"
}
```
Response

```json
{
    "message": "Your profile has been update successfully",
    "patient": {
        "id": 51,
        "first_name": "jolly",
        "middle_name": "middle man",
        "last_name": "jelof",
        "chcode": "CHP250204837",
        "avatar": "avatar/avatar.jpeg",
        "email": "email@email.com",
        "dob": null,
        "gender": "other",
        "phone": "09765436773",
        "address": "i leave where i leave",
        "city": "ph",
        "state": "rivers",
        "country": "niaja",
        "active": 1,
        "religion": null,
        "marital_status": null,
        "token": "MewlIYYbWjtFXUUGn1BR2LtEIkpIikarBrOpJncC",
        "nok_name": null,
        "nok_phone": null,
        "nok_email": null,
        "nok_address": null,
        "nok_city": null,
        "nok_state": null,
        "emergency_hospital_address": null,
        "emergency_hospital_name": null,
        "verify_token": "3D15Wlz2QbbQCNEcHVVtTqnev9n99AFJDlAoU9ha",
        "status": 0,
        "nok_country": null,
        "remember_token": null,
        "created_at": "2018-09-05 14:08:52",
        "updated_at": "2018-09-06 12:49:53"
    }
}
```

### Get all shared profile

**`GET api/patient/profile/shares`**

```json
{
    "message": "Shares retrieved successfully",
    "shares": [
        {
            "id": 1,
            "patient_id": 1,
            "provider_type": "App\\Models\\Laboratory",
            "provider_id": 1,
            "expired_at": "2018-09-10 00:00:00",
            "doctor_id": null,
            "status": "0",
            "created_at": "2018-09-09 18:01:56",
            "updated_at": "2018-09-09 18:01:56"
        },
        {
            "id": 2,
            "patient_id": 1,
            "provider_type": "App\\Models\\Laboratory",
            "provider_id": 1,
            "expired_at": "2018-09-10 00:00:00",
            "doctor_id": null,
            "status": "0",
            "created_at": "2018-09-09 18:06:08",
            "updated_at": "2018-09-09 18:06:08"
        },
        {
            "id": 3,
            "patient_id": 1,
            "provider_type": "App\\Models\\Laboratory",
            "provider_id": 1,
            "expired_at": "2018-09-10 00:00:00",
            "doctor_id": null,
            "status": "0",
            "created_at": "2018-09-09 18:06:42",
            "updated_at": "2018-09-09 18:06:42"
        }
    ]
}
```

Patient Can cancel his shared profile

**`PATCH api/patient/profile/shares/{shareOne}/expire`**

```
{shareOne} = shareProfile->id 
```

Scheme Data

```json
{
  "expiration": "2018-09-07"
}
```

Response

```json
{
    "message": "Share expired successfully",
    "share": {
        "id": 2,
        "patient_id": 51,
        "provider_type": "App\\Models\\Doctor",
        "provider_id": 62,
        "expired_at": "2018-09-06 13:14:36",
        "doctor_id": null,
        "status": "0",
        "created_at": "2018-09-05 15:38:59",
        "updated_at": "2018-09-06 13:15:06"
    }
}
```



Patient Can cancel his shared profile

**`PATCH api/patient/profile/shares/{shareOne}/expire`**
```
{shareOne} = profileShare->id 
```

Scheme Data

```json
{
  "expiration": "2018-09-07"
}
```

Response

```json
{
    "message": "Share expired successfully",
    "share": {
        "id": 2,
        "patient_id": 51,
        "provider_type": "App\\Models\\Doctor",
        "provider_id": 62,
        "expired_at": "2018-09-06 13:14:36",
        "doctor_id": null,
        "status": "0",
        "created_at": "2018-09-05 15:38:59",
        "updated_at": "2018-09-06 13:15:06"
    }
}
```

Patient can add emergency route

**`PATCH api/patient/{patient}/emergency`**

Scheme Data

```json
{
  "emergency_hospital_address": "My Emergency address name 3342",
  "emergency_hospital_name": "Emergency Hospital"
}
```

Response

```json
{
    "message": "congratulation you have updated your emergency profile",
    "patient": {
        "id": 51,
        "first_name": "jolly",
        "middle_name": "middle man",
        "last_name": "jelof",
        "chcode": "CHP250204837",
        "avatar": "avatar/avatar.jpeg",
        "email": "email@email.com",
        "dob": null,
        "gender": "other",
        "phone": "09765436773",
        "address": "i leave where i leave",
        "city": "ph",
        "state": "rivers",
        "country": "niaja",
        "active": 1,
        "religion": null,
        "marital_status": null,
        "token": "MewlIYYbWjtFXUUGn1BR2LtEIkpIikarBrOpJncC",
        "nok_name": null,
        "nok_phone": null,
        "nok_email": null,
        "nok_address": null,
        "nok_city": null,
        "nok_state": null,
        "emergency_hospital_address": "My Emergency address name 3342",
        "emergency_hospital_name": "Emergency Hospital",
        "verify_token": "3D15Wlz2QbbQCNEcHVVtTqnev9n99AFJDlAoU9ha",
        "status": 0,
        "nok_country": null,
        "remember_token": null,
        "created_at": "2018-09-05 14:08:52",
        "updated_at": "2018-09-06 13:56:59"
    }
}
```

