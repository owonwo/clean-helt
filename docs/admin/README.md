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
                 "id": 18,
                 "first_name": "Iva",
                 "middle_name": "Rippin",
                 "last_name": "Gerlach",
                 "chcode": "CHP176024257",
                 "avatar": "avatar/avatar.jpeg",
                 "email": "consuelo.waelchi@example.net",
                 "dob": "1977-10-06",
                 "gender": "female",
                 "phone": "786.926.2235 x86497",
                 "address": "4927 Ward Views Apt. 798\nPatsyhaven, ID 20631",
                 "city": "West Sadyehaven",
                 "state": "Lake Noemy",
                 "country": "Morocco",
                 "active": 1,
                 "religion": "Muslim",
                 "marital_status": "single",
                 "token": null,
                 "nok_name": "Dr. Devante Quitzon DDS",
                 "nok_phone": "+1 (226) 226-5922",
                 "nok_email": "urunolfsdottir@example.com",
                 "nok_address": "4242 Metz Flats Suite 509\nPort Quincyview, UT 01711-6762",
                 "nok_city": "Florianmouth",
                 "nok_state": "West Lucioshire",
                 "emergency_hospital_address": null,
                 "emergency_hospital_name": null,
                 "verify_token": null,
                 "status": 0,
                 "nok_country": null,
                 "remember_token": null,
                 "created_at": "2018-09-12 14:00:33",
                 "updated_at": "2018-09-12 14:00:33"
             },
             {
                 "id": 16,
                 "first_name": "Makenzie",
                 "middle_name": "Funk",
                 "last_name": "Goyette",
                 "chcode": "CHP492369756",
                 "avatar": "avatar/avatar.jpeg",
                 "email": "brooke.gislason@example.org",
                 "dob": "1970-02-16",
                 "gender": "female",
                 "phone": "+1.715.654.6563",
                 "address": "7243 Andrew Station Apt. 597\nPort Declan, NJ 46600-9797",
                 "city": "New Eladiochester",
                 "state": "Port Doug",
                 "country": "Saint Pierre and Miquelon",
                 "active": 1,
                 "religion": "Muslim",
                 "marital_status": "married",
                 "token": null,
                 "nok_name": "Graciela Kohler",
                 "nok_phone": "430-224-0541 x85052",
                 "nok_email": "kyra.hill@example.net",
                 "nok_address": "6111 Abshire Field\nSouth Alejandrinstad, NE 42319",
                 "nok_city": "North Destiny",
                 "nok_state": "Port Deron",
                 "emergency_hospital_address": null,
                 "emergency_hospital_name": null,
                 "verify_token": null,
                 "status": 0,
                 "nok_country": null,
                 "remember_token": null,
                 "created_at": "2018-09-12 14:00:31",
                 "updated_at": "2018-09-12 14:00:31"
             },
             {
                 "id": 17,
                 "first_name": "Kayleigh",
                 "middle_name": "Paucek",
                 "last_name": "Rohan",
                 "chcode": "CHP603392184",
                 "avatar": "avatar/avatar.jpeg",
                 "email": "nicole25@example.net",
                 "dob": "1997-10-30",
                 "gender": "female",
                 "phone": "743-919-0071",
                 "address": "85900 Krajcik Knoll\nZacheryborough, FL 59108-7178",
                 "city": "New Anika",
                 "state": "Port Omerstad",
                 "country": "Uganda",
                 "active": 1,
                 "religion": "Christianity",
                 "marital_status": "divorced",
                 "token": null,
                 "nok_name": "Ms. Clementina Stroman Sr.",
                 "nok_phone": "1-503-268-2385 x576",
                 "nok_email": "ooberbrunner@example.com",
                 "nok_address": "5477 Duane Expressway Suite 591\nNew Deondre, MD 23362-0031",
                 "nok_city": "Strosinmouth",
                 "nok_state": "Port Earltown",
                 "emergency_hospital_address": null,
                 "emergency_hospital_name": null,
                 "verify_token": null,
                 "status": 0,
                 "nok_country": null,
                 "remember_token": null,
                 "created_at": "2018-09-12 14:00:31",
                 "updated_at": "2018-09-12 14:00:31"
             },
             {
                 "id": 14,
                 "first_name": "Rhea",
                 "middle_name": "Hudson",
                 "last_name": "Boyle",
                 "chcode": "CHP257003811",
                 "avatar": "avatar/avatar.jpeg",
                 "email": "amaya25@example.org",
                 "dob": "1971-10-23",
                 "gender": "female",
                 "phone": "+13422689566",
                 "address": "12168 Thompson Land\nEast Natborough, NC 44973",
                 "city": "New Lulaview",
                 "state": "Klockofort",
                 "country": "Germany",
                 "active": 1,
                 "religion": "Christianity",
                 "marital_status": "engaged",
                 "token": null,
                 "nok_name": "Prof. Ephraim Zulauf",
                 "nok_phone": "+1-812-769-2286",
                 "nok_email": "jaida29@example.com",
                 "nok_address": "3449 Graham Junction\nAdityaberg, DC 89401-0218",
                 "nok_city": "New Fredaport",
                 "nok_state": "Olsonmouth",
                 "emergency_hospital_address": null,
                 "emergency_hospital_name": null,
                 "verify_token": null,
                 "status": 0,
                 "nok_country": null,
                 "remember_token": null,
                 "created_at": "2018-09-12 14:00:30",
                 "updated_at": "2018-09-12 14:00:30"
             },
             {
                 "id": 15,
                 "first_name": "Hilbert",
                 "middle_name": "Balistreri",
                 "last_name": "Erdman",
                 "chcode": "CHP043238724",
                 "avatar": "avatar/avatar.jpeg",
                 "email": "candice11@example.com",
                 "dob": "1978-10-20",
                 "gender": "male",
                 "phone": "+1-290-289-9569",
                 "address": "552 Herta Shoal Apt. 592\nNew Abdul, AZ 64217",
                 "city": "East Juanita",
                 "state": "West Cydney",
                 "country": "Norway",
                 "active": 1,
                 "religion": "Christianity",
                 "marital_status": "divorced",
                 "token": null,
                 "nok_name": "Santino Wisozk",
                 "nok_phone": "+1 (564) 823-0336",
                 "nok_email": "nat.schmidt@example.org",
                 "nok_address": "20868 Price Ford\nNorth Anibal, OH 39825",
                 "nok_city": "New Dovieshire",
                 "nok_state": "East Rosalindaburgh",
                 "emergency_hospital_address": null,
                 "emergency_hospital_name": null,
                 "verify_token": null,
                 "status": 0,
                 "nok_country": null,
                 "remember_token": null,
                 "created_at": "2018-09-12 14:00:30",
                 "updated_at": "2018-09-12 14:00:30"
             },
             {
                 "id": 12,
                 "first_name": "Jevon",
                 "middle_name": "Kassulke",
                 "last_name": "Ritchie",
                 "chcode": "CHP741709524",
                 "avatar": "avatar/avatar.jpeg",
                 "email": "bartell.raegan@example.org",
                 "dob": "2000-10-07",
                 "gender": "male",
                 "phone": "805.929.5283",
                 "address": "50120 Connelly Ridges\nLangworthmouth, NE 78619-9529",
                 "city": "South Jedediah",
                 "state": "Lake Blanche",
                 "country": "Cocos (Keeling) Islands",
                 "active": 1,
                 "religion": "Christianity",
                 "marital_status": "engaged",
                 "token": null,
                 "nok_name": "Ms. Serena Keebler",
                 "nok_phone": "345-294-0219 x60364",
                 "nok_email": "bednar.ralph@example.net",
                 "nok_address": "8277 Gutkowski Fort Apt. 360\nAstridstad, NV 82835",
                 "nok_city": "Maggiomouth",
                 "nok_state": "Johnsonmouth",
                 "emergency_hospital_address": null,
                 "emergency_hospital_name": null,
                 "verify_token": null,
                 "status": 0,
                 "nok_country": null,
                 "remember_token": null,
                 "created_at": "2018-09-12 14:00:29",
                 "updated_at": "2018-09-12 14:00:29"
             },
             {
                 "id": 13,
                 "first_name": "Roger",
                 "middle_name": "Romaguera",
                 "last_name": "Kub",
                 "chcode": "CHP638019820",
                 "avatar": "avatar/avatar.jpeg",
                 "email": "owillms@example.net",
                 "dob": "1998-01-29",
                 "gender": "male",
                 "phone": "+1-308-620-9829",
                 "address": "50005 McDermott Path Suite 899\nGradyport, MN 40698",
                 "city": "Grahamberg",
                 "state": "Harveyshire",
                 "country": "Tanzania",
                 "active": 1,
                 "religion": "Muslim",
                 "marital_status": "divorced",
                 "token": null,
                 "nok_name": "Vicenta Tillman II",
                 "nok_phone": "481.773.3994 x564",
                 "nok_email": "vferry@example.net",
                 "nok_address": "1005 Gordon Passage Suite 605\nMaddisonmouth, GA 08859",
                 "nok_city": "North Matilda",
                 "nok_state": "New Ethel",
                 "emergency_hospital_address": null,
                 "emergency_hospital_name": null,
                 "verify_token": null,
                 "status": 0,
                 "nok_country": null,
                 "remember_token": null,
                 "created_at": "2018-09-12 14:00:29",
                 "updated_at": "2018-09-12 14:00:29"
             },
             {
                 "id": 11,
                 "first_name": "Dan",
                 "middle_name": "Davis",
                 "last_name": "Terry",
                 "chcode": "CHP392082746",
                 "avatar": "avatar/avatar.jpeg",
                 "email": "ora16@example.org",
                 "dob": "1984-11-22",
                 "gender": "female",
                 "phone": "267-224-9753 x424",
                 "address": "9886 Kuhlman Hollow Apt. 222\nEast Fletcher, DE 06787",
                 "city": "North Rebekashire",
                 "state": "New Nathen",
                 "country": "Luxembourg",
                 "active": 1,
                 "religion": "Muslim",
                 "marital_status": "divorced",
                 "token": null,
                 "nok_name": "Mr. Oda Little V",
                 "nok_phone": "638-214-8336",
                 "nok_email": "carmella.harris@example.net",
                 "nok_address": "693 Little Ramp Suite 569\nPort Oswaldo, WY 16382-5656",
                 "nok_city": "East Haroldborough",
                 "nok_state": "South Columbusfurt",
                 "emergency_hospital_address": null,
                 "emergency_hospital_name": null,
                 "verify_token": null,
                 "status": 0,
                 "nok_country": null,
                 "remember_token": null,
                 "created_at": "2018-09-12 14:00:28",
                 "updated_at": "2018-09-12 14:00:28"
             },
             {
                 "id": 3,
                 "first_name": "Octavia",
                 "middle_name": "McClure",
                 "last_name": "Daniel",
                 "chcode": "CHP185034302",
                 "avatar": "avatar/avatar.jpeg",
                 "email": "pamela.wilkinson@example.com",
                 "dob": "2008-05-19",
                 "gender": "male",
                 "phone": "1-816-916-4234 x41422",
                 "address": "455 Berneice Knolls Suite 043\nBartolettifort, ND 41477",
                 "city": "Goyettebury",
                 "state": "Denesikhaven",
                 "country": "Italy",
                 "active": 1,
                 "religion": "Muslim",
                 "marital_status": "single",
                 "token": null,
                 "nok_name": "Samson McClure DDS",
                 "nok_phone": "959-491-7967",
                 "nok_email": "wisozk.may@example.org",
                 "nok_address": "8049 Powlowski Motorway\nPort Hildaville, OR 07354-4257",
                 "nok_city": "Beattyberg",
                 "nok_state": "Lake Murphy",
                 "emergency_hospital_address": null,
                 "emergency_hospital_name": null,
                 "verify_token": null,
                 "status": 0,
                 "nok_country": null,
                 "remember_token": null,
                 "created_at": "2018-09-12 14:00:22",
                 "updated_at": "2018-09-12 14:00:22"
             },
             {
                 "id": 4,
                 "first_name": "Lorenza",
                 "middle_name": "Reichert",
                 "last_name": "Gusikowski",
                 "chcode": "CHP730219049",
                 "avatar": "avatar/avatar.jpeg",
                 "email": "ryley.armstrong@example.com",
                 "dob": "2011-06-16",
                 "gender": "female",
                 "phone": "(628) 565-9557 x808",
                 "address": "865 Flavio Loaf\nCollinsfort, MN 47426",
                 "city": "Harrisside",
                 "state": "New Adellastad",
                 "country": "Macao",
                 "active": 1,
                 "religion": "Muslim",
                 "marital_status": "single",
                 "token": null,
                 "nok_name": "Mr. Rylan Effertz",
                 "nok_phone": "+1.515.920.6868",
                 "nok_email": "zakary76@example.org",
                 "nok_address": "3288 Eichmann Plain Suite 609\nNorth Rutheside, VT 51271-5811",
                 "nok_city": "South Augustafurt",
                 "nok_state": "Port Marisa",
                 "emergency_hospital_address": null,
                 "emergency_hospital_name": null,
                 "verify_token": null,
                 "status": 0,
                 "nok_country": null,
                 "remember_token": null,
                 "created_at": "2018-09-12 14:00:22",
                 "updated_at": "2018-09-12 14:00:22"
             },
             {
                 "id": 5,
                 "first_name": "Cassidy",
                 "middle_name": "Kassulke",
                 "last_name": "Wiza",
                 "chcode": "CHP420560411",
                 "avatar": "avatar/avatar.jpeg",
                 "email": "bethany.watsica@example.org",
                 "dob": "2010-09-18",
                 "gender": "male",
                 "phone": "276-298-4148 x1519",
                 "address": "12635 Haag Summit Apt. 172\nPort Chaya, SD 05660-9500",
                 "city": "Erlingside",
                 "state": "East Roelhaven",
                 "country": "Russian Federation",
                 "active": 1,
                 "religion": "Muslim",
                 "marital_status": "single",
                 "token": null,
                 "nok_name": "Mr. Kevin Mraz PhD",
                 "nok_phone": "+1 (384) 405-5018",
                 "nok_email": "zack49@example.com",
                 "nok_address": "3577 Schmitt Keys\nHazleport, CA 92808",
                 "nok_city": "Ernserland",
                 "nok_state": "Myrticemouth",
                 "emergency_hospital_address": null,
                 "emergency_hospital_name": null,
                 "verify_token": null,
                 "status": 0,
                 "nok_country": null,
                 "remember_token": null,
                 "created_at": "2018-09-12 14:00:22",
                 "updated_at": "2018-09-12 14:00:22"
             },
             {
                 "id": 6,
                 "first_name": "Odell",
                 "middle_name": "Ondricka",
                 "last_name": "Medhurst",
                 "chcode": "CHP235763829",
                 "avatar": "avatar/avatar.jpeg",
                 "email": "kozey.sheila@example.net",
                 "dob": "2006-02-02",
                 "gender": "male",
                 "phone": "(605) 839-4600 x8038",
                 "address": "904 Kacey Drive Apt. 786\nKubview, WV 43738-6820",
                 "city": "Kuhicville",
                 "state": "West Lolaborough",
                 "country": "South Africa",
                 "active": 1,
                 "religion": "Christianity",
                 "marital_status": "single",
                 "token": null,
                 "nok_name": "Dr. Jaime Willms Sr.",
                 "nok_phone": "(968) 914-8351 x4584",
                 "nok_email": "zparisian@example.com",
                 "nok_address": "930 Imani Ranch\nNew Andreanneville, WY 68019",
                 "nok_city": "Tevinfort",
                 "nok_state": "Maximillianmouth",
                 "emergency_hospital_address": null,
                 "emergency_hospital_name": null,
                 "verify_token": null,
                 "status": 0,
                 "nok_country": null,
                 "remember_token": null,
                 "created_at": "2018-09-12 14:00:22",
                 "updated_at": "2018-09-12 14:00:22"
             },
             {
                 "id": 7,
                 "first_name": "Kallie",
                 "middle_name": "Rippin",
                 "last_name": "Macejkovic",
                 "chcode": "CHP689711233",
                 "avatar": "avatar/avatar.jpeg",
                 "email": "tchamplin@example.org",
                 "dob": "1988-09-24",
                 "gender": "female",
                 "phone": "1-890-271-9700",
                 "address": "73098 Genesis Path\nNorth Felixside, MN 54863",
                 "city": "North Orinstad",
                 "state": "Mullerburgh",
                 "country": "Lesotho",
                 "active": 1,
                 "religion": "Christianity",
                 "marital_status": "single",
                 "token": null,
                 "nok_name": "Chance Kunze",
                 "nok_phone": "514-940-8795",
                 "nok_email": "deondre.brown@example.com",
                 "nok_address": "86474 Rene Ferry\nCierrastad, AR 91263",
                 "nok_city": "South Susana",
                 "nok_state": "South Natalia",
                 "emergency_hospital_address": null,
                 "emergency_hospital_name": null,
                 "verify_token": null,
                 "status": 0,
                 "nok_country": null,
                 "remember_token": null,
                 "created_at": "2018-09-12 14:00:22",
                 "updated_at": "2018-09-12 14:00:22"
             },
             {
                 "id": 8,
                 "first_name": "Baby",
                 "middle_name": "Gutkowski",
                 "last_name": "DuBuque",
                 "chcode": "CHP182876142",
                 "avatar": "avatar/avatar.jpeg",
                 "email": "eloy.erdman@example.net",
                 "dob": "1997-11-30",
                 "gender": "male",
                 "phone": "(613) 512-7295 x637",
                 "address": "8078 Omer Harbor Suite 219\nGreenholtstad, AL 01591",
                 "city": "Hirthetown",
                 "state": "Bernhardhaven",
                 "country": "Malawi",
                 "active": 1,
                 "religion": "Christianity",
                 "marital_status": "married",
                 "token": null,
                 "nok_name": "Benjamin Klocko",
                 "nok_phone": "(324) 272-6436 x5146",
                 "nok_email": "baby66@example.com",
                 "nok_address": "587 Florida Fords\nSouth Ellsworthhaven, MT 23800-6090",
                 "nok_city": "New General",
                 "nok_state": "West Kara",
                 "emergency_hospital_address": null,
                 "emergency_hospital_name": null,
                 "verify_token": null,
                 "status": 0,
                 "nok_country": null,
                 "remember_token": null,
                 "created_at": "2018-09-12 14:00:22",
                 "updated_at": "2018-09-12 14:00:22"
             },
             {
                 "id": 9,
                 "first_name": "Casimir",
                 "middle_name": "Hartmann",
                 "last_name": "Kemmer",
                 "chcode": "CHP068502609",
                 "avatar": "avatar/avatar.jpeg",
                 "email": "phowell@example.com",
                 "dob": "2007-10-15",
                 "gender": "male",
                 "phone": "607.882.6310 x85551",
                 "address": "21022 Littel Squares Suite 622\nFeilborough, CT 28863-9645",
                 "city": "South Kamronport",
                 "state": "North Nels",
                 "country": "Northern Mariana Islands",
                 "active": 1,
                 "religion": "Muslim",
                 "marital_status": "single",
                 "token": null,
                 "nok_name": "Dr. Sheldon Schoen MD",
                 "nok_phone": "1-564-749-9915",
                 "nok_email": "kiehn.carlie@example.net",
                 "nok_address": "34247 Quinn Manors Suite 883\nRogahnport, ND 98144",
                 "nok_city": "Emeraldbury",
                 "nok_state": "Port Maximillia",
                 "emergency_hospital_address": null,
                 "emergency_hospital_name": null,
                 "verify_token": null,
                 "status": 0,
                 "nok_country": null,
                 "remember_token": null,
                 "created_at": "2018-09-12 14:00:22",
                 "updated_at": "2018-09-12 14:00:22"
             }
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
 }
```

**`GET \patients\{patient}`**

```json
{
    "message": "Laboratory fetched successfully",
    "patient": {
        "id": 17,
        "first_name": "Kayleigh",
        "middle_name": "Paucek",
        "last_name": "Rohan",
        "chcode": "CHP603392184",
        "avatar": "avatar/avatar.jpeg",
        "email": "nicole25@example.net",
        "dob": "1997-10-30",
        "gender": "female",
        "phone": "743-919-0071",
        "address": "85900 Krajcik Knoll\nZacheryborough, FL 59108-7178",
        "city": "New Anika",
        "state": "Port Omerstad",
        "country": "Uganda",
        "active": 1,
        "religion": "Christianity",
        "marital_status": "divorced",
        "token": null,
        "nok_name": "Ms. Clementina Stroman Sr.",
        "nok_phone": "1-503-268-2385 x576",
        "nok_email": "ooberbrunner@example.com",
        "nok_address": "5477 Duane Expressway Suite 591\nNew Deondre, MD 23362-0031",
        "nok_city": "Strosinmouth",
        "nok_state": "Port Earltown",
        "emergency_hospital_address": null,
        "emergency_hospital_name": null,
        "verify_token": null,
        "status": 0,
        "nok_country": null,
        "remember_token": null,
        "created_at": "2018-09-12 14:00:31",
        "updated_at": "2018-09-12 14:00:31"
    }
}
```

### create patient 

**`POST api/admin/patients`**

```json
{
    "message": "Patient created successfully",
    "patient": {
        "first_name": "my name",
        "last_name": "myname",
        "email": "emadil@email.com",
        "phone": "09034758693",
        "chcode": "CHP329074958",
        "updated_at": "2018-09-19 23:02:03",
        "created_at": "2018-09-19 23:02:03",
        "id": 20
    }
}
```

### Update Patient

**`PATCH api/admin/patients/CHP329074958`**

```json
{
    "message": "Laboratory updated successfully ",
    "patient": {
        "id": 20,
        "first_name": "my name",
        "middle_name": null,
        "last_name": "myname",
        "chcode": "CHP329074958",
        "avatar": null,
        "email": "emadil@email.com",
        "dob": null,
        "gender": "other",
        "phone": "09034758693",
        "address": null,
        "city": null,
        "state": null,
        "country": null,
        "active": 1,
        "religion": null,
        "marital_status": null,
        "token": null,
        "nok_name": null,
        "nok_phone": null,
        "nok_email": null,
        "nok_address": null,
        "nok_city": null,
        "nok_state": null,
        "emergency_hospital_address": null,
        "emergency_hospital_name": null,
        "verify_token": null,
        "status": 0,
        "nok_country": null,
        "remember_token": null,
        "created_at": "2018-09-19 23:02:03",
        "updated_at": "2018-09-19 23:02:03"
    }
}
```

### Deactivate Patient

**`PATCH api/admin/patients/CHP329074958/deactivate`**

```json
{
    "message": "Laboratory updated successfully ",
    "patient": {
        "id": 20,
        "first_name": "my name",
        "middle_name": null,
        "last_name": "myname",
        "chcode": "CHP329074958",
        "avatar": null,
        "email": "emadil@email.com",
        "dob": null,
        "gender": "other",
        "phone": "09034758693",
        "address": null,
        "city": null,
        "state": null,
        "country": null,
        "active": 1,
        "religion": null,
        "marital_status": null,
        "token": null,
        "nok_name": null,
        "nok_phone": null,
        "nok_email": null,
        "nok_address": null,
        "nok_city": null,
        "nok_state": null,
        "emergency_hospital_address": null,
        "emergency_hospital_name": null,
        "verify_token": null,
        "status": 0,
        "nok_country": null,
        "remember_token": null,
        "created_at": "2018-09-19 23:02:03",
        "updated_at": "2018-09-19 23:02:03"
    }
}
```


### Delete Patient

**`DELETE /api/admin/patients/CHP329074958`**

```json
{
    "message": "Patient was successfully deleted "
}
```