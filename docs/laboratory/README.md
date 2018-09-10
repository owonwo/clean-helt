## API Documentation For Laboratories

### Laboratory Login

**`POST api/login/laboratory`** 

Sample Data

```json
{
    "email": "dibbert.norris@example.net",
    "password": "secret"
}
```
Response 
```json
{
    "user": {
        "id": 1,
        "name": "Ms. Margret Hermiston II",
        "chcode": "CHL253897231",
        "licence_no": "AqtUzH4ghl6esTd",
        "email": "dibbert.norris@example.net",
        "phone": "541.553.3597",
        "address": "87810 Dalton Road New Rosanna, NE 20056-6885",
        "city": "Shirleyhaven",
        "state": "North Sethton",
        "country": "Italy",
        "lab_owner": "Ms. Mariana Heaney DVM",
        "cac_reg": "lzrLNja4OnwLmj5",
        "fmoh_reg": "vqZhBs2qKdJ5KGs",
        "active": 1,
        "avatar": null,
        "token": null,
        "offers": "Voluptatum natus accusantium voluptas culpa labore. Autem a aperiam numquam dolores. Quis fugit veniam aut reiciendis eligendi eos. Odio fuga facilis voluptatem facilis omnis harum in eum. Tempore doloremque aperiam est blanditiis nesciunt exercitationem.",
        "remember_token": null,
        "created_at": "2018-09-08 09:29:15",
        "updated_at": "2018-09-08 09:29:15"
    },
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ijk1ZjNjYWE0N2ZlMDY2ZTU3ODJhMWI4ZmU0YjEzNDQyYjNkNTJlNDVkMzNmNjkwZjVlOTlhMTIzYzI3ODVjNjZhYzdjNGM0YTVjNTFhMzliIn0.eyJhdWQiOiIxIiwianRpIjoiOTVmM2NhYTQ3ZmUwNjZlNTc4MmExYjhmZTRiMTM0NDJiM2Q1MmU0NWQzM2Y2OTBmNWU5OWExMjNjMjc4NWM2NmFjN2M0YzRhNWM1MWEzOWIiLCJpYXQiOjE1MzY0MDEwODEsIm5iZiI6MTUzNjQwMTA4MSwiZXhwIjoxNTY3OTM3MDgxLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.fom26m2xQ7nWsiuAxXM-uJRB0XjPSJ9eoNlaHoMjXRu2Ya6dN2mQfi9k9V7wVZgPRNmsD5qSWq8pq0dZvipvmz9yuW2YgJ4aPWWgGF-8uLgMm3LPMzmOHtDVImdKhAq9zpQaxau_LXiObyJEJWkThIhF0fqEhylUc1i5CqeXh8DUk4WZlcZzgZWVI5a6M6lZhJOJQ2WY2Uebfs3AD0DxCyHQac5H-3BNavKUldHO_JJQ4FgXZFP6ktY-t46bMrX5JeS4Pr3ovZb0eSv2SXcVzkyLvJYpHaG4X7zjRO-v3aMXjs5KKT8kw-lRQRIaLFgx9iEOIum_EZBSmWwlzo6Q5x1dOvdewTPzATZB_JfsR95rEJWNO0wQs4RNwW7WL7NupZ9umZYIsn7nU7jKZHPlcwxchl-j0cFOjlddUTI1w5sA2UDNagYTy9RrSNqzHJKMibtqnwRQ3s-14_3uIZX5SfGsUtj9jo49QIOeYQN9n36vrwW4LQCG91aVXqPer8Vm_LbjM2MW_vt74ahwS6vbXvNArC6E2ufamLCDZA4PiA0ZigQHbqlVA1pSKSmR3W_R0nEK4RgNK8H6OmjcRmSdXchfvQtGpetF3dLMXlfy-un1Bh8woK1ICKPliUJTIDLN1bOr_zTU2Sa7mRGZBLqiE1FiNk_GPhPQHSRH05XeBlA",
    "expires_in": 21600
}
```
<br/>

### Laboratory profile

**`GET api/laboratories/profile`**

```json
{
    "message": "logged in successfully",
    "laboratory": {
        "id": 1,
        "name": "Ms. Margret Hermiston II",
        "chcode": "CHL253897231",
        "licence_no": "AqtUzH4ghl6esTd",
        "email": "dibbert.norris@example.net",
        "phone": "541.553.3597",
        "address": "87810 Dalton Road\nNew Rosanna, NE 20056-6885",
        "city": "Shirleyhaven",
        "state": "North Sethton",
        "country": "Italy",
        "lab_owner": "Ms. Mariana Heaney DVM",
        "cac_reg": "lzrLNja4OnwLmj5",
        "fmoh_reg": "vqZhBs2qKdJ5KGs",
        "active": 1,
        "avatar": null,
        "token": null,
        "offers": "Voluptatum natus accusantium voluptas culpa labore. Autem a aperiam numquam dolores. Quis fugit veniam aut reiciendis eligendi eos. Odio fuga facilis voluptatem facilis omnis harum in eum. Tempore doloremque aperiam est blanditiis nesciunt exercitationem.",
        "remember_token": null,
        "created_at": "2018-09-08 09:29:15",
        "updated_at": "2018-09-08 09:29:15"
    }
}
```

### Laboratory Profile update

**`PATCH api/laboratories/profile/update`**

Response
```json
{
    "message": "Laboratory updated successfully ",
    "labs": {
        "id": 1,
        "name": "Ms. Margret Hermiston II",
        "chcode": "CHL253897231",
        "licence_no": "AqtUzH4ghl6esTd",
        "email": "dibbert.norris@example.net",
        "phone": "541.553.3597",
        "address": "87810 Dalton Road\nNew Rosanna, NE 20056-6885",
        "city": "Shirleyhaven",
        "state": "North Sethton",
        "country": "Italy",
        "lab_owner": "Ms. Mariana Heaney DVM",
        "cac_reg": "lzrLNja4OnwLmj5",
        "fmoh_reg": "vqZhBs2qKdJ5KGs",
        "active": 1,
        "avatar": null,
        "token": null,
        "offers": "Voluptatum natus accusantium voluptas culpa labore. Autem a aperiam numquam dolores. Quis fugit veniam aut reiciendis eligendi eos. Odio fuga facilis voluptatem facilis omnis harum in eum. Tempore doloremque aperiam est blanditiis nesciunt exercitationem.",
        "remember_token": null,
        "created_at": "2018-09-08 09:29:15",
        "updated_at": "2018-09-08 09:29:15"
    }
}
```

<br/>

## Laboratory Profile Share

### View shared pending Profile

**`GET api/laboratories/patient/pending`**

```json
{
    "message": "Patient Shared his medical record",
    "laboratory": [
        {
            "id": 4,
            "patient_id": 1,
            "provider_type": "App\\Models\\Laboratory",
            "provider_id": 1,
            "expired_at": "2018-09-11 00:00:00",
            "doctor_id": null,
            "status": "0",
            "created_at": "2018-09-10 00:30:31",
            "updated_at": "2018-09-10 00:30:31",
            "patient": {
                "id": 1,
                "first_name": "Matt",
                "middle_name": "Goodwin",
                "last_name": "Lang",
                "chcode": "CHP529100918",
                "avatar": "avatar/avatar.jpeg",
                "email": "example@example.com",
                "dob": "2001-07-03",
                "gender": "female",
                "phone": "+19684660787",
                "address": "31200 Will Cliffs\nSouth Ryanstad, SD 20519",
                "city": "Marquesville",
                "state": "South Marcelinofort",
                "country": "Mauritius",
                "active": 1,
                "religion": "Christianity",
                "marital_status": "engaged",
                "token": null,
                "nok_name": "Rhoda Rutherford",
                "nok_phone": "(905) 250-4441 x4736",
                "nok_email": "bogan.norberto@example.net",
                "nok_address": "2503 Jaylin Crest Apt. 561\nWest Felipabury, MN 75239-3242",
                "nok_city": "Thompsonmouth",
                "nok_state": "West Althea",
                "emergency_hospital_address": null,
                "emergency_hospital_name": null,
                "verify_token": null,
                "status": 0,
                "nok_country": null,
                "remember_token": null,
                "created_at": "2018-09-08 09:26:25",
                "updated_at": "2018-09-08 09:26:25"
            }
        }
    ]
}
```

<br/>


### Accept shared profile

**`PATCH patient/{profileShare}/accept`**


```
{profileShare} = $profileshare->id
```

Sample Data

```json
{
    "status": 1
}
```
Response 

```json
{
    "message": "You have accept patient profile for a period of time",
    "laboratory": {
        "id": 4,
        "patient_id": 1,
        "provider_type": "App\\Models\\Laboratory",
        "provider_id": 1,
        "expired_at": "2018-09-11 00:00:00",
        "doctor_id": null,
        "status": "1",
        "created_at": "2018-09-10 00:30:31",
        "updated_at": "2018-09-10 00:52:04"
    }
}
```

<br/>

### Decline Profile Share

**`PATCH patient/{profileShare}/decline`**


```
{profileShare} = $profileshare->id
```

Sample Data

```json
{
    "status": 2
}
```
Response

```json
{
    "message": "You've just decline a patient profile share!",
    "laboratory": {
        "id": 4,
        "patient_id": 1,
        "provider_type": "App\\Models\\Laboratory",
        "provider_id": 1,
        "expired_at": "2018-09-11 00:00:00",
        "doctor_id": null,
        "status": 2,
        "created_at": "2018-09-10 00:30:31",
        "updated_at": "2018-09-10 00:58:11"
    }
}
```

## Access Medical Records

