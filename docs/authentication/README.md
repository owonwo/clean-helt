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
  "email": "kelley20@example.com",
  "password": "secret"
}
```

Sample Response

```json
{
    "user": {
        "id": 1,
        "name": "New Era Hospital",
        "email": "kelley20@example.com",
        "chcode": "CHH293415609", 
        "director_mdcn": "natus",
        "phone": "252-582-5657 x62181", 
        "address": "673 Niko Corner Apt. 054\nVivianneville, IA 48169",
        "city": "Luisfurt",
        "state": "Hodkiewiczview",
        "country": "Mongolia",
        "website": null,
        "facility_type": null,
        "facility_owner": null,
        "cac_reg": null,
        "cac_date": null,
        "fmoh_reg": null,
        "fmoh_date": null,
        "admin_name": null,
        "admin_position": null,
        "admin_phone":null, 
        "services": null,
        "bank_name": null,
        "bank_branch": null,
        "account_name": null,
        "account_number": null,
        "active": 1,
        "avatar": "avatar/avatar.jpeg",
        "remember_token": null,
        "created_at": "2018-09-03 20:16:47",
        "updated_at": "2018-09-03 21:57:02",
        "deleted_at":null
    },
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQxYzMzNzEzMTg5YjRjMmYwZTk5ZDk5ZGE1NzMzNTUwNmMyNjU4Mzg0YjA3MTY5ZWU2MzdkZjcwNDQxMzNjZDczNTM1ZmExYmIxNzdhYTJmIn0.eyJhdWQiOiIxIiwianRpIjoiZDFjMzM3MTMxODliNGMyZjBlOTlkOTlkYTU3MzM1NTA2YzI2NTgzODRiMDcxNjllZTYzN2RmNzA0NDEzM2NkNzM1MzVmYTFiYjE3N2FhMmYiLCJpYXQiOjE1MzYwNjMyNjYsIm5iZiI6MTUzNjA2MzI2NiwiZXhwIjoxNTY3NTk5MjY1LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.Q6K2qjG4bUspThIkZ15bNhsbHfOWxLm4AN3dMPK4UOYil2T0h_gSdLAfTHLRYEC1Jet3lwDh1GWwixP44XN2-eD7wG2QCrV7o2ofSn5OCZ2ni1veZaQl70-v1gfB4FAEewEVnWtqErBTFj25h6xKCjObVpBqx6rIB8DWM06jO2ii6bvGJANK7aMRfio4ccaVBAUu17h06QpB7IU_m-UcC3F_v0X87iUmr5qCy6tBzysPfgxzawjhxoqcvJG0T--lKQo5d2I9KFprCSSeD4J1GZXNamwB6kqUrtGeoWHSzHOxtKYfUdP0tdtvDgrGU1nLy46DM0jEGvCHdtmep9hOT9i8ok1jvhNHSAk4v4BZBDYvb0DyMKAxGGqALmnDWNhlL0bc_LyZV8Ywow14CkyU13KgWWip78y_CQrL4ziNcLsl3X5PEQkQzKM-daMKfD3KWDMXLOMOVFfkX1xRTnfE5Of7TgucWtwfMoEIv-tKKvtBEb65qACjQeeUOP0z_VQyIQPqS6G43Za_g_2iKaJeu7safgGMbWlHZNF9S9WJeMnmT2vlpIYZcx2JYwHKeuTBBh3PCHUOOw3rrhG8An3k0xG98sHM6mlXfZZlAV3fuwaLju4MF_K4IzBs9gOkLZ3ktipsnDvggtjluOCLw03l8H1KpAb_6_PBMMGb5PJESyo",
    "expires_in": 21600
}
```

### Pharmacies

#### Login

**`POST /login/pharmacy`**

Logs in a pharmacy

Sample Data:

```json
{
  "email": "edd62@example.org",
  "password": "secret"
}
```

Sample Response

```json
{
    "user": {
        "id": 1,
        "name": "Prof. Blair Flatley",
        "chcode": "CHF400665321",
        "email":"edd62@example.org",
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
    },
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQxYzMzNzEzMTg5YjRjMmYwZTk5ZDk5ZGE1NzMzNTUwNmMyNjU4Mzg0YjA3MTY5ZWU2MzdkZjcwNDQxMzNjZDczNTM1ZmExYmIxNzdhYTJmIn0.eyJhdWQiOiIxIiwianRpIjoiZDFjMzM3MTMxODliNGMyZjBlOTlkOTlkYTU3MzM1NTA2YzI2NTgzODRiMDcxNjllZTYzN2RmNzA0NDEzM2NkNzM1MzVmYTFiYjE3N2FhMmYiLCJpYXQiOjE1MzYwNjMyNjYsIm5iZiI6MTUzNjA2MzI2NiwiZXhwIjoxNTY3NTk5MjY1LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.Q6K2qjG4bUspThIkZ15bNhsbHfOWxLm4AN3dMPK4UOYil2T0h_gSdLAfTHLRYEC1Jet3lwDh1GWwixP44XN2-eD7wG2QCrV7o2ofSn5OCZ2ni1veZaQl70-v1gfB4FAEewEVnWtqErBTFj25h6xKCjObVpBqx6rIB8DWM06jO2ii6bvGJANK7aMRfio4ccaVBAUu17h06QpB7IU_m-UcC3F_v0X87iUmr5qCy6tBzysPfgxzawjhxoqcvJG0T--lKQo5d2I9KFprCSSeD4J1GZXNamwB6kqUrtGeoWHSzHOxtKYfUdP0tdtvDgrGU1nLy46DM0jEGvCHdtmep9hOT9i8ok1jvhNHSAk4v4BZBDYvb0DyMKAxGGqALmnDWNhlL0bc_LyZV8Ywow14CkyU13KgWWip78y_CQrL4ziNcLsl3X5PEQkQzKM-daMKfD3KWDMXLOMOVFfkX1xRTnfE5Of7TgucWtwfMoEIv-tKKvtBEb65qACjQeeUOP0z_VQyIQPqS6G43Za_g_2iKaJeu7safgGMbWlHZNF9S9WJeMnmT2vlpIYZcx2JYwHKeuTBBh3PCHUOOw3rrhG8An3k0xG98sHM6mlXfZZlAV3fuwaLju4MF_K4IzBs9gOkLZ3ktipsnDvggtjluOCLw03l8H1KpAb_6_PBMMGb5PJESyo",
    "expires_in": 21600
}
```