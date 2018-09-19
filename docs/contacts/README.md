## CONTACTS MODULE (BOOKMARKS)

### Patients

**`GET /api/patient/contacts`**

Returns a list of an authenticated patient's contacts (bookmarks)


Sample Response

```json
{
    "contacts": [
        {
            "id": 1,
            "owner_id": 2,
            "owner_type": "App\\Models\\Patient",
            "contact_id": 27,
            "contact_type": "App\\Models\\Doctor",
            "created_at": "2018-09-19 20:40:29",
            "updated_at": "2018-09-19 20:40:29",
            "contact": {
                "id": 27,
                "first_name": "Lauryn",
                "middle_name": "Heidenreich",
                "last_name": "Kunze",
                "email": "keebler.al@hoppe.info",
                "phone": "1-229-673-1519 x456",
                "gender": "male",
                "specialization": "cardiologist",
                "folio": "MB/12/Gu",
                "confirm": false,
                "validation": 0,
                "chcode": "CHD460912821",
                "token": "VkYQoHX6CVarWjPia1OeRJplj3OuqS5S11I6tuhU",
                "remember_token": null,
                "deleted_at": null,
                "created_at": "2018-09-19 20:40:29",
                "updated_at": "2018-09-19 20:40:29",
                "profile": null,
                "hospitals": []
            }
        },
        {
            "id": 2,
            "owner_id": 2,
            "owner_type": "App\\Models\\Patient",
            "contact_id": 28,
            "contact_type": "App\\Models\\Doctor",
            "created_at": "2018-09-19 20:40:29",
            "updated_at": "2018-09-19 20:40:29",
            "contact": {
                "id": 28,
                "first_name": "Glenda",
                "middle_name": "Carter",
                "last_name": "Glover",
                "email": "avery21@collins.com",
                "phone": "(691) 933-4452 x4767",
                "gender": "male",
                "specialization": "cardiologist",
                "folio": "MB/12/LI",
                "confirm": false,
                "validation": 0,
                "chcode": "CHD232934902",
                "token": "C3hWsCLS4DT5UapHclbX7mWEOcm9DXpyR619ocdX",
                "remember_token": null,
                "deleted_at": null,
                "created_at": "2018-09-19 20:40:29",
                "updated_at": "2018-09-19 20:40:29",
                "profile": null,
                "hospitals": []
            }
        }
    ]
}
```

**`POST /api/patient/contacts`**

Adds a model with the provided chcode to the authenticated patient's contacts

Sample Data

```json
    {
      "chcode": "CHDXXXXXXX"
    }
```

Sample Response

```json
{
    "message": "contact added successfully",
    "contact": {
        "contact_id": 1,
        "contact_type": "App\\Models\\Doctor",
        "owner_id": 2,
        "owner_type": "App\\Models\\Patient",
        "updated_at": "2018-09-19 20:45:45",
        "created_at": "2018-09-19 20:45:45",
        "id": 11,
        "contact": {
            "id": 1,
            "first_name": "Marcel",
            "middle_name": "Hagenes",
            "last_name": "Haag",
            "email": "dessie.conrey@gmail.com",
            "phone": "623-214-6007 x28574",
            "gender": "female",
            "specialization": "cardiologist",
            "folio": "MB/12/7d",
            "confirm": false,
            "validation": 0,
            "chcode": "CHD984092751",
            "token": "i74U2gPLhVVigDGXnYSWRL30BLAb9TnZ8cbO7sQu",
            "remember_token": null,
            "deleted_at": null,
            "created_at": "2018-09-03 20:16:47",
            "updated_at": "2018-09-03 20:16:47",
            "profile": {
                "id": 1,
                "doctors_id": 1,
                "address": "7103 Steuber Ports Suite 010\nEast Toymouth, MN 75426-6214",
                "city": "Bogisichborough",
                "state": "Runtetown",
                "country": "Western Sahara",
                "mode_of_contact": 0,
                "marital_status": "Single",
                "religion": "Christianity",
                "kin_fullname": "Catharine Marks",
                "kin_address": "6575 Rosenbaum Crossing Apt. 710\nNew Joesph, OK 95636",
                "kin_phone": "498-714-3314",
                "kin_city": "East Fannie",
                "kin_state": "Lake Bernard",
                "kin_country": "Somalia",
                "name_of_degree": "Doctrate Degree",
                "institution": "Rivers State university",
                "additional_degree": "Bachelor of Science",
                "years_in_practice": 4,
                "active": 1,
                "avatar": "avatar/avatar.jpg",
                "disability": "Tenetur deleniti adipisci inventore vel impedit id alias. Cumque in ut id reprehenderit similique voluptas aut id. Blanditiis consequuntur ab quo exercitationem expedita facilis voluptas.",
                "created_at": "2018-09-03 20:16:47",
                "updated_at": "2018-09-03 20:16:47"
            },
            "hospitals": [
                {
                    "id": 3,
                    "name": "Watson Durgan Hospital",
                    "email": "spencer.eleazar@example.com",
                    "chcode": "CHH233105274",
                    "director_mdcn": "vel",
                    "phone": "+1-729-506-8745",
                    "address": "1290 Sauer Field\nNorth Alfredland, OR 08939",
                    "city": "Marcialand",
                    "state": "New Carole",
                    "country": "Palau",
                    "website": null,
                    "facility_type": null,
                    "facility_owner": null,
                    "cac_reg": null,
                    "cac_date": null,
                    "fmoh_reg": null,
                    "fmoh_date": null,
                    "admin_name": null,
                    "admin_position": null,
                    "admin_phone": null,
                    "services": null,
                    "bank_name": null,
                    "bank_branch": null,
                    "account_name": null,
                    "account_number": null,
                    "active": 1,
                    "avatar": "avatar/avatar.jpeg",
                    "remember_token": null,
                    "created_at": "2018-09-03 20:16:47",
                    "updated_at": "2018-09-03 20:16:47",
                    "deleted_at": null,
                    "pivot": {
                        "doctor_id": 1,
                        "hospital_id": 3
                    }
                }
            ]
        }
    }
}
```

**`DELETE /api/patient/contacts/{contact}`**

Deletes a contact from an authenticated patient's contact list

NOTE:

```
{contact} => ID (PK)
```

Sample Response

```json
{
    "message": "Contact removed successfully"
}
```