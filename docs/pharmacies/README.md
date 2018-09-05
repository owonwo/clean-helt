## Pharmacy API Documentation

### Profile Management

**`GET /profile`**

Returns an authenticated pharmacy's profile information.

Sample Response:

```json
{
    "message": "Pharmacy retrieved successfully",
    "pharmacy": {
        "id": 1,
        "name": "Prof. Blair Flatley",
        "chcode": "CHF400665321",
        "email": "edd62@example.org",
        "phone": "1-624-364-8590",
        "address": "88468 Walsh Pines Apt. 767\nGleasonberg, NY 34054-8409",
        "city": "Port Kirstenshire",
        "state": "Adamsborough",
        "country": "Bolivia",
        "business_name": null,
        "business_type": null,
        "facility_owner": null,
        "cac_reg": null,
        "cac_date": null,
        "fmoh_reg": null,
        "fmoh_date": null,
        "chief_pharmacist_reg": "consequatur",
        "active": 1,
        "avatar": "avatar/avatar.jpeg",
        "chief_pharmacist_reg_date": null,
        "chief_pharmacist_name": null,
        "chief_pharmacist_phone": null,
        "services": null,
        "remember_token": null,
        "created_at": "2018-09-03 20:16:47",
        "updated_at": "2018-09-03 20:16:47"
    }
}
```

**`PATCH /profile`**

Updates an authenticated pharmacy's profile information.

Sample Data:

```json
{
  "name": "Clean Helt Pharmacies"
} 
```

Sample Response:

```json
    {
        "message":"Profile updated successfully",
        "pharmacy": {
            "id": 1,
            "name": "Clean Helt Pharmacies",
            "chcode": "CHF400665321",
            "email": "edd62@example.org",
            "phone": "1-624-364-8590",
            "address": "88468 Walsh Pines Apt. 767\nGleasonberg, NY 34054-8409",
            "city": "Port Kirstenshire",
            "state": "Adamsborough",
            "country": "Bolivia",
            "business_name": null,
            "business_type": null,
            "facility_owner": null,
            "cac_reg": null,
            "cac_date": null,
            "fmoh_reg": null,
            "fmoh_date": null,
            "chief_pharmacist_reg": "consequatur",
            "active": 1,
            "avatar": "avatar/avatar.jpeg",
            "chief_pharmacist_reg_date": null,
            "chief_pharmacist_name": null,
            "chief_pharmacist_phone": null,
            "services": null,
            "remember_token": null,
            "created_at": "2018-09-03 20:16:47",
            "updated_at": "2018-09-05 17:38:35"
        }
    }
```
<br/>

### Patient Management

**`GET /patients`**

Returns a list of patients a pharmacy has.

Sample Response:

```json
{
    "message": "Patients retrieved successfully",
    "patients": [
        {
            "id": 1,
            "patient_id": 1,
            "provider_type": "App\\Models\\Pharmacy",
            "provider_id": 1,
            "expired_at": "2018-10-01 00:00:00",
            "doctor_id": 1,
            "status": "1",
            "created_at": null,
            "updated_at": "2018-09-04 14:56:38",
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

Returns a list of a patient's prescription records.

Request Modifiers (Search Params)
```
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
                "id": 4,
                "reference": "CHR207791129",
                "patient_id": 1,
                "type": "App\\Models\\Prescription",
                "issuer_type": "App\\Models\\Doctor",
                "issuer_id": 15,
                "created_at": "2018-09-03 20:16:47",
                "updated_at": "2018-09-03 20:16:47",
                "deleted_at": null
            }
        ],
        "first_page_url": "http://clean-helt-api.test/api/pharmacy/patients/CHP306622590/records?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://clean-helt-api.test/api/pharmacy/patients/CHP306622590/records?page=1",
        "next_page_url": null,
        "path": "http://clean-helt-api.test/api/pharmacy/patients/CHP306622590/records",
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

Returns the details of a patient's single medical record.

Sample Response:
```json
{
    "data": {
        "id": 4,
        "reference": "CHR207791129",
        "patient_id": 1,
        "type": "App\\Models\\Prescription",
        "issuer_type": "App\\Models\\Doctor",
        "issuer_id": 15,
        "created_at": "2018-09-03 20:16:47",
        "updated_at": "2018-09-03 20:16:47",
        "deleted_at": null,
        "data": [
            {
                "id": 1,
                "record_id": 4,
                "quantity": 4,
                "frequency": 3,
                "name": "Clean Helt Pharmacies",
                "pharmacy_id": 11,
                "diagnosis_id": 3,
                "comment": "Et officiis dolorum ut.",
                "status": 1,
                "created_at": "2018-09-03 20:16:47",
                "updated_at": "2018-09-05 18:16:09"
            }
        ]
    }
}
```
<br/>

**`PATCH patients/{patient}/records/{medicalRecord}/{prescription}`**

```
{patient} => patient's chcode
{medicalRecord} => record's reference
{prescription} => Prescription's id
```

Marks a prescription as dispensed.

Sample Response:
```json
{
    "message": "Prescription dispensed successfully",
    "prescription": {
        "id": 1,
        "record_id": 4,
        "quantity": 4,
        "frequency": 3,
        "name": "Clean Helt Pharmacies",
        "pharmacy_id": 11,
        "diagnosis_id": 3,
        "comment": "Et officiis dolorum ut.",
        "status": 1,
        "created_at": "2018-09-03 20:16:47",
        "updated_at": "2018-09-05 18:16:09"
    },
    "record": {
        "id": 4,
        "reference": "CHR207791129",
        "patient_id": 1,
        "type": "App\\Models\\Prescription",
        "issuer_type": "App\\Models\\Doctor",
        "issuer_id": 15,
        "created_at": "2018-09-03 20:16:47",
        "updated_at": "2018-09-03 20:16:47",
        "deleted_at": null
    }
}
```
<br/>

### Profile Share Management

**`GET /patients/pending`**

Returns a list of pending patients (profile shares) a pharmacy has.

Sample Response:

```json
{
    "message": "Patients retrieved successfully",
    "patients": [
        {
            "id": 1,
            "patient_id": 1,
            "provider_type": "App\\Models\\Pharmacy",
            "provider_id": 1,
            "expired_at": "2018-10-01 00:00:00",
            "doctor_id": 1,
            "status": "0",
            "created_at": null,
            "updated_at": "2018-09-04 14:56:38",
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
        "provider_type": "App\\Models\\Pharmacy",
        "provider_id": 1,
        "expired_at": "2018-10-01 00:00:00",
        "doctor_id": 1,
        "status": "1",
        "created_at": null,
        "updated_at": "2018-09-05 18:33:02"
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
        "provider_type": "App\\Models\\Pharmacy",
        "provider_id": 1,
        "expired_at": "2018-10-01 00:00:00",
        "doctor_id": 1,
        "status": 2,
        "created_at": null,
        "updated_at": "2018-09-05 18:33:54"
    }
}
```
<br/>