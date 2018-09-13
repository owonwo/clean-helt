## Admin Manages Hospital 

### Base URL

**`BASE URL: /api/admin`**

### Hospital

**`GET /hospitals`**

```
{hospital} => hospital's chcode
```

Returns  all hospitals made by the admin

Sample Response:

```json
    {
      "message":"Hospital retrieved successfully",
      "hospitals": {
              "current_page": 1,
              "data": [
                  {
                      "id": 1,
                      "name": "Karine Marks V Hospital",
                      "email": "mfunk@example.net",
                      "chcode": "CHH138974922",
                      "director_mdcn": "molestiae",
                      "phone": "+1-509-852-2554",
                      "address": "6846 Ernser Meadows Apt. 909\nEast Patience, MI 88583-3937",
                      "city": "Port Ellis",
                      "state": "Franeckiburgh",
                      "country": "Togo",
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
                      "created_at": "2018-09-08 09:03:25",
                      "updated_at": "2018-09-08 09:03:25",
                      "deleted_at": null
                  }]
           },
            "first_page_url": "http://yoururl/api/admin/hospitals?page=1",
            "from": 1,
            "last_page": 1,
            "last_page_url": "http://yoururl/api/admin/hospitals?page=1",
            "next_page_url": null,
            "path": "http://yoururl/api/admin/hospitals",
            "per_page": 20,
            "prev_page_url": null,
            "to": 10,
            "total": 10
    }
```

**`POST /hospitals`**

Creates a new Hospital

Sample Data:

```json
{
    "hospital" : {
     "name":"New Era Hospital", //String
     "email":"kelley20@example.com", //String
     "chcode":"CHH293415609", //String
     "director_mdcn":"natus", //String
     "phone":"252-582-5657 x62181", //String
     "address":"673 Niko Corner Apt. 054\nVivianneville, IA 48169", //String
     "city":"Luisfurt", //String
     "state":"Hodkiewiczview", //String
     "country":"Mongolia", //String
     "website": "http://fishes.com", // String
     "facility_type":"", //Integer
     "facility_owner":"", //Integer
     "cac_reg":"", //String
     "cac_date":"", //Date
     "fmoh_reg":"", //String
     "fmoh_date":"",  //Date
     "admin_name":"", //String
     "admin_position":null, // String
     "admin_phone":"080920939", //String
     "services":"", // Text
     "bank_name":"Fidelitiy Bank", //String
     "bank_branch":"Diobu",  //String
     "account_name": "Bradley Yarrow", //String
     "account_number":"090909090" // String
     }
} 
```

Sample Response:

```json
    {
      "message":"Hospital Created successfully",
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

**`PATCH /hospitals/{hospital}`**

Sample Data:

```json
    {
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
          "remember_token":null
      }
   
```
Sample Response:

```json
        {
            "message" : "Hospital Updated success fully",
            "hospital" : {
                          
            }
        }
```
Get a single hospital
 
**`GET /hospitals/{hospital}`**

Sample Response

```json
      {
        "message" : "Hospital Loaded Successfully",
        "hospital" : {
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
          "remember_token":null
        }
      }
```
Delete a Hospital

**`DELETE /hospitals/{hospital}`**

Sample Data

```json
    {
       "chcode" : "CH458506085"
    }
```

Response Data
```json
    {
       "message" : "Deleted Successfully",
       "hospital" : []
    }
```

<br/>

### Doctors

**`GET /doctors`**

```
{doctor} => doctor's chcode
```

Returns a list of Doctors.

Sample Response:

```json
{
    "message": "Doctors retrieved successfully",
    "doctors": [
        {
          "id": 1,
              "first_name": "Maurice",
              "middle_name": "Zulauf",
              "last_name": "Kohler",
              "email": "dessie.conrey@gmail.com",
              "phone": "+18633737880",
              "gender": "male",
              "specialization": "cardiologist",
              "folio": "MB/12/Nu",
              "confirm": false,
              "validation": true,
              "chcode": "CHD309199683",
              "api_token": "mp4rTknR9YEknX9GoJXyAxzQFrDe90uqZDrDkSdw",
              "token": "MNFG8XDoOa2tGj8iN1oDSiEZOkvQTtAMQ25MMjDQ",
              "remember_token": null,
              "deleted_at": null,
              "created_at": "2018-09-08 09:03:22",
              "updated_at": "2018-09-11 14:55:33",
              "profile": {
                  "id": 1,
                  "doctors_id": 1,
                  "address": "5585 Earline Throughway Apt. 068\nSouth Emiltown, WA 04748-9203",
                  "city": "Stammmouth",
                  "state": "Paolostad",
                  "country": "Malta",
                  "mode_of_contact": 0,
                  "marital_status": "Single",
                  "religion": "Christianity",
                  "kin_fullname": "Jordy Beier",
                  "kin_address": "99006 Gennaro Branch Apt. 528\nBorerfurt, MA 36654-0449",
                  "kin_phone": "794.894.9781 x6862",
                  "kin_city": "South Jodymouth",
                  "kin_state": "Port Coty",
                  "kin_country": "Poland",
                  "name_of_degree": "Doctrate Degree",
                  "institution": "Rivers State university",
                  "additional_degree": "Bachelor of Science",
                  "years_in_practice": 4,
                  "active": 0,
                  "avatar": "avatar/avatar.jpg",
                  "disability": "Unde ad est qui et ea itaque aperiam. Adipisci magni aut sit similique alias vel nam. Voluptas possimus sit sed cupiditate nesciunt.",
                  "created_at": "2018-09-08 09:03:22",
                  "updated_at": "2018-09-11 14:54:28"
              }
        }
    ]
}
```

**`GET /doctors/{doctor}`**

Returns a Particular Doctor

Sample Response:

```json
{
    "message": "Doctor retrieved successfully",
    "doctor": {
        "id": 1,
            "first_name": "Maurice",
            "middle_name": "Zulauf",
            "last_name": "Kohler",
            "email": "dessie.conrey@gmail.com",
            "phone": "+18633737880",
            "gender": "male",
            "specialization": "cardiologist",
            "folio": "MB/12/Nu",
            "confirm": false,
            "validation": true,
            "chcode": "CHD309199683",
            "api_token": "mp4rTknR9YEknX9GoJXyAxzQFrDe90uqZDrDkSdw",
            "token": "MNFG8XDoOa2tGj8iN1oDSiEZOkvQTtAMQ25MMjDQ",
            "remember_token": null,
            "deleted_at": null,
            "created_at": "2018-09-08 09:03:22",
            "updated_at": "2018-09-11 14:55:33",
            "profile": {
                "id": 1,
                "doctors_id": 1,
                "address": "5585 Earline Throughway Apt. 068\nSouth Emiltown, WA 04748-9203",
                "city": "Stammmouth",
                "state": "Paolostad",
                "country": "Malta",
                "mode_of_contact": 0,
                "marital_status": "Single",
                "religion": "Christianity",
                "kin_fullname": "Jordy Beier",
                "kin_address": "99006 Gennaro Branch Apt. 528\nBorerfurt, MA 36654-0449",
                "kin_phone": "794.894.9781 x6862",
                "kin_city": "South Jodymouth",
                "kin_state": "Port Coty",
                "kin_country": "Poland",
                "name_of_degree": "Doctrate Degree",
                "institution": "Rivers State university",
                "additional_degree": "Bachelor of Science",
                "years_in_practice": 4,
                "active": 0,
                "avatar": "avatar/avatar.jpg",
                "disability": "Unde ad est qui et ea itaque aperiam. Adipisci magni aut sit similique alias vel nam. Voluptas possimus sit sed cupiditate nesciunt.",
                "created_at": "2018-09-08 09:03:22",
                "updated_at": "2018-09-11 14:54:28"
            }
    }
}

```
**`PATCH /doctors/verify/{doctor}`**

Verifies a particular Doctor

Just hist the route endpoint and it verify's the doctor

Sample Response

```json
     {
        "message" : "Activated Successfully",
        "doctor" : []
     }
```

<br/>

**`PATCH /doctors/activate/{doctor}`**

Activates the Doctor

Just hit The route

Sample Response: 

```json
     {
        "message" : "Activated Successfully",
        "doctor" : []
     }
```

**`DELETE /doctors/destroy/{doctor}`**

Deletes a doctor

Just hit the route

```json
     {
        "message" : "Deleted Successfully",
        "doctor" : []
     }
```

<br/>

**`PATCH doctors/update/{doctor}`**

Sample Data
```json
     {
        "first_name" : "New Value"
     }
```

### Pharmacy

**`GET \pharmacies`**

Sample Response

```json
      {
        "message" : "Pharmacies loaded successful",
        "pharmacies": {
            "current_page": 1,
            "data": [
                {
                    "id": 14,
                    "name": "Sofia Douglas",
                    "chcode": "CHF824926782",
                    "email": "jarvis57@example.net",
                    "phone": "+1.395.914.1758",
                    "address": "7120 Savion Inlet\nAbdullahfort, AR 36640",
                    "city": "Port Allisonberg",
                    "state": "New Enastad",
                    "country": "Finland",
                    "business_name": null,
                    "business_type": null,
                    "facility_owner": null,
                    "cac_reg": null,
                    "cac_date": null,
                    "fmoh_reg": null,
                    "fmoh_date": null,
                    "chief_pharmacist_reg": "consectetur",
                    "active": 1,
                    "avatar": "avatar/avatar.jpeg",
                    "chief_pharmacist_reg_date": null,
                    "chief_pharmacist_name": null,
                    "chief_pharmacist_phone": null,
                    "services": null,
                    "remember_token": null,
                    "created_at": "2018-09-08 09:03:35",
                    "updated_at": "2018-09-08 09:03:35"
                }]
            }
       }
```
    

**`POST \pharmacies`**

Sample Data

```json
    {
        "name": "Sofia Douglas",
        "chcode": "CHF824926782",
        "email": "jarvis57@example.net",
        "phone": "+1.395.914.1758",
        "address": "7120 Savion Inlet\nAbdullahfort, AR 36640",
        "city": "Port Allisonberg",
        "state": "New Enastad",
        "country": "Finland",
        "business_name": null,
        "business_type": null,
        "facility_owner": null,
        "cac_reg": null,
        "cac_date": null,
        "fmoh_reg": null,
        "fmoh_date": null,
        "chief_pharmacist_reg": "consectetur",
        "active": 1,
        "avatar": "avatar/avatar.jpeg",
        "chief_pharmacist_reg_date": null,
        "chief_pharmacist_name": null,
        "chief_pharmacist_phone": null,
        "services": null
    }
```

Sample Response

```json
   {
       "message": "Pharmacy Created successfully",
       "pharmacy": {
           "id": 14,
           "name": "Sofia Douglas",
           "chcode": "CHF824926782",
           "email": "jarvis57@example.net",
           "phone": "+1.395.914.1758",
           "address": "7120 Savion Inlet\nAbdullahfort, AR 36640",
           "city": "Port Allisonberg",
           "state": "New Enastad",
           "country": "Finland",
           "business_name": null,
           "business_type": null,
           "facility_owner": null,
           "cac_reg": null,
           "cac_date": null,
           "fmoh_reg": null,
           "fmoh_date": null,
           "chief_pharmacist_reg": "consectetur",
           "active": 1,
           "avatar": "avatar/avatar.jpeg",
           "chief_pharmacist_reg_date": null,
           "chief_pharmacist_name": null,
           "chief_pharmacist_phone": null,
           "services": null,
           "remember_token": null,
           "created_at": "2018-09-08 09:03:35",
           "updated_at": "2018-09-08 09:03:35"
       }
   }
```

**`GET \pharmacy\{pharmacy}`**

Gets only one pharmacy

Sample Response
```json
   {
       "message": "Pharmacy Created successfully",
       "pharmacy": {
           "id": 14,
           "name": "Sofia Douglas",
           "chcode": "CHF824926782",
           "email": "jarvis57@example.net",
           "phone": "+1.395.914.1758",
           "address": "7120 Savion Inlet\nAbdullahfort, AR 36640",
           "city": "Port Allisonberg",
           "state": "New Enastad",
           "country": "Finland",
           "business_name": null,
           "business_type": null,
           "facility_owner": null,
           "cac_reg": null,
           "cac_date": null,
           "fmoh_reg": null,
           "fmoh_date": null,
           "chief_pharmacist_reg": "consectetur",
           "active": 1,
           "avatar": "avatar/avatar.jpeg",
           "chief_pharmacist_reg_date": null,
           "chief_pharmacist_name": null,
           "chief_pharmacist_phone": null,
           "services": null,
           "remember_token": null,
           "created_at": "2018-09-08 09:03:35",
           "updated_at": "2018-09-08 09:03:35"
       }
   }
```

**`PATCH \pharmacies\{pharmacy}`**

Updates the pharmacy information

Sample Data

```json
    {
      "name" : "Value"
    }
```
Sample Response
```json
    {
      "message" : "Doctor has been updated successfully"
    }
```

**`DELETE \pharmacies\{pharmacy}`**

Deletes the pharmacy

Just hit the route

Sample Response 
```json
   {
    "message" : "deleted successfully"
   }
```
<br>

### Laboratory

**`GET /laboratories`**

Gets all laboratories

Sample Data

```json
    {
          "message" : "Lab loaded successfully",
          "labs": {
              "current_page": 1,
              "data": [
                  {
                      "id": 4,
                      "name": "Rachael Walter",
                      "chcode": "CHL461073373",
                      "licence_no": "0nswzvE4aWbS2bP",
                      "email": "leonardo.littel@example.net",
                      "phone": "708-915-1453 x87786",
                      "address": "58108 Rusty Mountain Suite 803\nShieldsburgh, CT 36846-2739",
                      "city": "West Halstad",
                      "state": "Port Jarretstad",
                      "country": "Malawi",
                      "lab_owner": "Mrs. Lola Labadie PhD",
                      "cac_reg": "LzendIs1pvr8f1I",
                      "fmoh_reg": "BLkDKuzFZ8z3z7K",
                      "active": 1,
                      "avatar": null,
                      "token": null,
                      "offers": "Occaecati aperiam similique et et nam. Odio quis enim soluta eius. Officia aspernatur asperiores incidunt ipsa soluta dolorum cupiditate.",
                      "remember_token": null,
                      "created_at": "2018-09-08 09:03:35",
                      "updated_at": "2018-09-08 09:03:35"
                  }
                ]
             },
             "first_page_url": "http://localhost:8000/api/admin/laboratories?page=1",
             "from": 1,
             "last_page": 1,
             "last_page_url": "http://localhost:8000/api/admin/laboratories?page=1",
             "next_page_url": null,
             "path": "http://localhost:8000/api/admin/laboratories",
             "per_page": 15,
             "prev_page_url": null,
             "to": 4,
             "total": 4
    }
```

**`POST \laboratories`**

Creates a Laboratory

Sample Data

```json
    {
      "name": "Kristian Weissnat",
      "chcode": "CHL236670970",
      "licence_no": "bN4cXE4NDFpYVDu",
      "email": "esta.ondricka@example.org",
      "phone": "+14604256258",
      "address": "19828 Hessel Ranch\nNathanialborough, CO 13709",
      "city": "Brakusport",
      "state": "Reannaview",
      "country": "Uzbekistan",
      "lab_owner": "Yvette Durgan",
      "cac_reg": "ExebX0hafu2mUgm",
      "fmoh_reg": "qUK6q2Wzb6VKrDp",
      "active": 1,
      "avatar": null,
      "offers": "Quia excepturi aut quia sint voluptatem ab. Voluptatem iure et placeat reprehenderit tenetur. Fugiat accusamus eum ut porro temporibus ipsa vero."
    }
```
Sample Response

```json
   {
      "message" : "Pharmacy created Successfully",
      "laboratory" : {
                 "id": 1,
                 "name": "Kristian Weissnat",
                 "chcode": "CHL236670970",
                 "licence_no": "bN4cXE4NDFpYVDu",
                 "email": "esta.ondricka@example.org",
                 "phone": "+14604256258",
                 "address": "19828 Hessel Ranch\nNathanialborough, CO 13709",
                 "city": "Brakusport",
                 "state": "Reannaview",
                 "country": "Uzbekistan",
                 "lab_owner": "Yvette Durgan",
                 "cac_reg": "ExebX0hafu2mUgm",
                 "fmoh_reg": "qUK6q2Wzb6VKrDp",
                 "active": 1,
                 "avatar": null,
                 "token": null,
                 "offers": "Quia excepturi aut quia sint voluptatem ab. Voluptatem iure et placeat reprehenderit tenetur. Fugiat accusamus eum ut porro temporibus ipsa vero.",
                 "remember_token": null,
                 "created_at": "2018-09-08 09:03:31",
                 "updated_at": "2018-09-08 09:03:31"         
      }
   }
```
**`GET \laboratory\{laboratory}`**

Get a single Laboratory

Sample Response

```json
    {
        "message": "Laboratory fetched successfully",
        "laboratory": {
            "id": 1,
            "name": "Kristian Weissnat",
            "chcode": "CHL236670970",
            "licence_no": "bN4cXE4NDFpYVDu",
            "email": "esta.ondricka@example.org",
            "phone": "+14604256258",
            "address": "19828 Hessel Ranch\nNathanialborough, CO 13709",
            "city": "Brakusport",
            "state": "Reannaview",
            "country": "Uzbekistan",
            "lab_owner": "Yvette Durgan",
            "cac_reg": "ExebX0hafu2mUgm",
            "fmoh_reg": "qUK6q2Wzb6VKrDp",
            "active": 1,
            "avatar": null,
            "token": null,
            "offers": "Quia excepturi aut quia sint voluptatem ab. Voluptatem iure et placeat reprehenderit tenetur. Fugiat accusamus eum ut porro temporibus ipsa vero.",
            "remember_token": null,
            "created_at": "2018-09-08 09:03:31",
            "updated_at": "2018-09-08 09:03:31"
        }
    }
```
**`PATCH \laboratories\deactivate\{laboratory}`**

Toggles the Activation Status

Sample Response 

```json
    {
        "doctor": {
            "id": 1,
            "name": "Kristian Weissnat",
            "chcode": "CHL236670970",
            "licence_no": "bN4cXE4NDFpYVDu",
            "email": "esta.ondricka@example.org",
            "phone": "+14604256258",
            "address": "19828 Hessel Ranch\nNathanialborough, CO 13709",
            "city": "Brakusport",
            "state": "Reannaview",
            "country": "Uzbekistan",
            "lab_owner": "Yvette Durgan",
            "cac_reg": "ExebX0hafu2mUgm",
            "fmoh_reg": "qUK6q2Wzb6VKrDp",
            "active": true,
            "avatar": null,
            "token": null,
            "offers": "Quia excepturi aut quia sint voluptatem ab. Voluptatem iure et placeat reprehenderit tenetur. Fugiat accusamus eum ut porro temporibus ipsa vero.",
            "remember_token": null,
            "created_at": "2018-09-08 09:03:31",
            "updated_at": "2018-09-11 17:28:11"
        },
        "message": "Active changed"
    }
```

**`PATCH \laboratories\{laboratory}`**

Updates the Laboratory 

Sample Data

```json
    {
      "name" : "Value"
    }
```

Sample Response

```json
 {
     "doctor": {
         "id": 1,
         "name": "Kristian Weissnat",
         "chcode": "CHL236670970",
         "licence_no": "bN4cXE4NDFpYVDu",
         "email": "esta.ondricka@example.org",
         "phone": "+14604256258",
         "address": "19828 Hessel Ranch\nNathanialborough, CO 13709",
         "city": "Brakusport",
         "state": "Reannaview",
         "country": "Uzbekistan",
         "lab_owner": "Yvette Durgan",
         "cac_reg": "ExebX0hafu2mUgm",
         "fmoh_reg": "qUK6q2Wzb6VKrDp",
         "active": true,
         "avatar": null,
         "token": null,
         "offers": "Quia excepturi aut quia sint voluptatem ab. Voluptatem iure et placeat reprehenderit tenetur. Fugiat accusamus eum ut porro temporibus ipsa vero.",
         "remember_token": null,
         "created_at": "2018-09-08 09:03:31",
         "updated_at": "2018-09-11 17:28:11"
     },
     "message": "Active changed"
 }
```

**`DELETE \laboratories\{laboratory}`**

Deletes a Laboratory

Sample Response

```json
 {
     "message": "Laboratory was successfully deleted ",
     "Laboratory": {
         "id": 1,
         "name": "Kristian Weissnat",
         "chcode": "CHL236670970",
         "licence_no": "bN4cXE4NDFpYVDu",
         "email": "esta.ondricka@example.org",
         "phone": "+14604256258",
         "address": "19828 Hessel Ranch\nNathanialborough, CO 13709",
         "city": "Brakusport",
         "state": "Reannaview",
         "country": "Uzbekistan",
         "lab_owner": "Yvette Durgan",
         "cac_reg": "ExebX0hafu2mUgm",
         "fmoh_reg": "qUK6q2Wzb6VKrDp",
         "active": 1,
         "avatar": null,
         "token": null,
         "offers": "Quia excepturi aut quia sint voluptatem ab. Voluptatem iure et placeat reprehenderit tenetur. Fugiat accusamus eum ut porro temporibus ipsa vero.",
         "remember_token": null,
         "created_at": "2018-09-08 09:03:31",
         "updated_at": "2018-09-11 17:28:11"
     }
 }
```
### Patients

**`GET \patients`**
Get all patients on the Platforms

Sample Response
```json
 {
        "patients": {
            "current_page": 1,
            "data": [
                {
                    "id": 17,
                    "first_name": "Zoila",
                    "middle_name": "Dare",
                    "last_name": "Mueller",
                    "chcode": "CHP892937756",
                    "avatar": "avatar/avatar.jpeg",
                    "email": "grant.laisha@example.org",
                    "dob": "1980-12-01",
                    "gender": "female",
                    "phone": "783-462-2556 x0473",
                    "address": "108 Oswaldo Cove Suite 234\nWest Allie, CT 09711",
                    "city": "Sauerhaven",
                    "state": "Murphyland",
                    "country": "Fiji",
                    "active": 1,
                    "religion": "Muslim",
                    "marital_status": "engaged",
                    "token": null,
                    "nok_name": "Mr. Lucas Champlin",
                    "nok_phone": "(604) 817-4576",
                    "nok_email": "wolff.sabina@example.net",
                    "nok_address": "181 Schultz Lock Suite 116\nEast Easton, OH 77061-5031",
                    "nok_city": "Alenaport",
                    "nok_state": "Tavaresport",
                    "emergency_hospital_address": null,
                    "emergency_hospital_name": null,
                    "verify_token": null,
                    "status": 0,
                    "nok_country": null,
                    "remember_token": null,
                    "created_at": "2018-09-08 09:03:35",
                    "updated_at": "2018-09-08 09:03:35"
                  ],
                       "first_page_url": "http://localhost:8000/api/admin/patients?page=1",
                       "from": 1,
                       "last_page": 2,
                       "last_page_url": "http://localhost:8000/api/admin/patients?page=2",
                       "next_page_url": "http://localhost:8000/api/admin/patients?page=2",
                       "path": "http://localhost:8000/api/admin/patients",
                       "per_page": 15,
                       "prev_page_url": null,
                       "to": 15,
                       "total": 18
                   }
```

**`GET \patients\{patient}`**

