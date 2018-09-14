## Authentication

### Base URL

**`Base URL: /api`**

### Hospitals

#### Login

**`POST /login/hospital`**

Logs in a hospital

Sample Data:

```json
{
  "username": "kelley20@example.com",
  "password": "secret",
  "provider": "hospitals"
}
```

Sample Response

```json
{
    "token_data": {
        "token_type": "Bearer",
        "expires_in": 21599,
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImI3NmIzOTc2ODA5NWQxYWFlZGM2NDQzNjdjOWUzNzk5NmZhODlhMGU1ZmNkNmJlM2ZjZGJkNmIwNDcwOWIzN2I2MzY5MGZiZDFhOTVmODdkIn0.eyJhdWQiOiI4IiwianRpIjoiYjc2YjM5NzY4MDk1ZDFhYWVkYzY0NDM2N2M5ZTM3OTk2ZmE4OWEwZTVmY2Q2YmUzZmNkYmQ2YjA0NzA5YjM3YjYzNjkwZmJkMWE5NWY4N2QiLCJpYXQiOjE1MzY2ODUyOTAsIm5iZiI6MTUzNjY4NTI5MCwiZXhwIjoxNTM2NzA2ODg5LCJzdWIiOiIzIiwic2NvcGVzIjpbXX0.d8-cZZya3fb5IT0oVXTD5B4V-IAvW22EjED8eYHETNTAlwTkuwWioUE1pdedQusXAGVdeXUK602hcjwx9Eay1NnXNsZdIxJDeBVHZPVzLqNMNeDkFRN3L4AZKgZGTrSDR5P7i58qMnWCmXf-tEGltos4hO_z1ZpYsmsy_WLHU4Vdb-adLOJkjP_byZZUC0oCX1o-Asg-ERSWTX_QnXbBofyb5pH5FYyDw19pCxGabk2tODa5VixdWedAoaDWOQGfQdP4taQKD_MWXb1dsdPy3maPZdIqIzntkstTuKHn1IknJsUrA9Ypjl-Oc4XSYjMq9CDK2UmO1GCOgJBjY_-6DuwmNUC3-pP5qMc9Kk3J7dxOBihqPqeGIxmBEGJZv2C_6xey2y5AHnZxAK-yL6-jAXh8VtJWnZDxn2wxoeHOZ2ayTbA4Am2d-Da-T4gNFnLyNlLhCmATQ16-tlGyYAglurBbXfJoDvXhH8pLhtKlHXNA7_EuDFBAf_mVCWYcud0EQtW3yQj9uuBzPaKAUD5a9HQndhGbrmnMocH-byZbsfzJ4VHfstjGE9E3tQS07oJBT-BtWPETGxuHFzQq1R6zLtNWQGong4_FjzF-GkB-QEyIAy8Xq3u9ElU7cHiD4ZncB18pMqXd0uC80r8-NbVOsO7dUoScqDumIJWBW0DMFCk",
        "refresh_token": "def502005f3d9857354e1fd2a413de13cd931ea953fa127999143e553f34bb1b3b017b23f4e4fadd5d7b1dd8e15c99e39e527a74b99705c5242a4c8379a785d51ef97ec40d8f3b3b39d15b094467d3fc3c6ffa581d0ecae9120d947d4fd37f6e268f3b7084cfad0d088eaf2e0dbeb7c125150c10d14469eed40e4163443f5d74aca913d9e7fafcb249c2b2f5e4dba9af3a53915c80a01258c4da3078d028fc49e929224cdf356501bd59b1f26f786400b60cb8687e311214fd9c272ddd217cfc1729c751ca47fde24a015c738118e6a9b7d9e4191f0cd10e687efc5d34bddae30ffa3871415015298a268533b3d59d1f48c204c9935c6b14eddaa2250b11e6ee722f49071d67c58448e23c8f4cdabb5596bca7f6cea6813e6d1fbb5a28cdfb1225dc9c03fc571f2ee2b7045bbd4e1a9788153751ca35c40d4bd069d048b4a3f49d0d33cd2cd9d912488ceab539eb0573872607812b2cca7af1f78787985979e9fb"
    },
    "user": {
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
        "deleted_at": null
    }
}
```

### Pharmacies

#### Login

**`POST /login/pharmacy`**

Logs in a pharmacy

Sample Data:

```json
{
  "username": "edd62@example.org",
  "password": "secret",
  "provider": "pharmacies"
}
```

Sample Response

```json
{
    "token_data": {
        "token_type": "Bearer",
        "expires_in": 21599,
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImI3NmIzOTc2ODA5NWQxYWFlZGM2NDQzNjdjOWUzNzk5NmZhODlhMGU1ZmNkNmJlM2ZjZGJkNmIwNDcwOWIzN2I2MzY5MGZiZDFhOTVmODdkIn0.eyJhdWQiOiI4IiwianRpIjoiYjc2YjM5NzY4MDk1ZDFhYWVkYzY0NDM2N2M5ZTM3OTk2ZmE4OWEwZTVmY2Q2YmUzZmNkYmQ2YjA0NzA5YjM3YjYzNjkwZmJkMWE5NWY4N2QiLCJpYXQiOjE1MzY2ODUyOTAsIm5iZiI6MTUzNjY4NTI5MCwiZXhwIjoxNTM2NzA2ODg5LCJzdWIiOiIzIiwic2NvcGVzIjpbXX0.d8-cZZya3fb5IT0oVXTD5B4V-IAvW22EjED8eYHETNTAlwTkuwWioUE1pdedQusXAGVdeXUK602hcjwx9Eay1NnXNsZdIxJDeBVHZPVzLqNMNeDkFRN3L4AZKgZGTrSDR5P7i58qMnWCmXf-tEGltos4hO_z1ZpYsmsy_WLHU4Vdb-adLOJkjP_byZZUC0oCX1o-Asg-ERSWTX_QnXbBofyb5pH5FYyDw19pCxGabk2tODa5VixdWedAoaDWOQGfQdP4taQKD_MWXb1dsdPy3maPZdIqIzntkstTuKHn1IknJsUrA9Ypjl-Oc4XSYjMq9CDK2UmO1GCOgJBjY_-6DuwmNUC3-pP5qMc9Kk3J7dxOBihqPqeGIxmBEGJZv2C_6xey2y5AHnZxAK-yL6-jAXh8VtJWnZDxn2wxoeHOZ2ayTbA4Am2d-Da-T4gNFnLyNlLhCmATQ16-tlGyYAglurBbXfJoDvXhH8pLhtKlHXNA7_EuDFBAf_mVCWYcud0EQtW3yQj9uuBzPaKAUD5a9HQndhGbrmnMocH-byZbsfzJ4VHfstjGE9E3tQS07oJBT-BtWPETGxuHFzQq1R6zLtNWQGong4_FjzF-GkB-QEyIAy8Xq3u9ElU7cHiD4ZncB18pMqXd0uC80r8-NbVOsO7dUoScqDumIJWBW0DMFCk",
        "refresh_token": "def502005f3d9857354e1fd2a413de13cd931ea953fa127999143e553f34bb1b3b017b23f4e4fadd5d7b1dd8e15c99e39e527a74b99705c5242a4c8379a785d51ef97ec40d8f3b3b39d15b094467d3fc3c6ffa581d0ecae9120d947d4fd37f6e268f3b7084cfad0d088eaf2e0dbeb7c125150c10d14469eed40e4163443f5d74aca913d9e7fafcb249c2b2f5e4dba9af3a53915c80a01258c4da3078d028fc49e929224cdf356501bd59b1f26f786400b60cb8687e311214fd9c272ddd217cfc1729c751ca47fde24a015c738118e6a9b7d9e4191f0cd10e687efc5d34bddae30ffa3871415015298a268533b3d59d1f48c204c9935c6b14eddaa2250b11e6ee722f49071d67c58448e23c8f4cdabb5596bca7f6cea6813e6d1fbb5a28cdfb1225dc9c03fc571f2ee2b7045bbd4e1a9788153751ca35c40d4bd069d048b4a3f49d0d33cd2cd9d912488ceab539eb0573872607812b2cca7af1f78787985979e9fb"
    },
    "user": {
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