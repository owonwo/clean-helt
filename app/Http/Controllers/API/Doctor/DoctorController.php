<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorProfile;
use Illuminate\Http\Request;
use PhpParser\Comment\Doc;

class DoctorController extends Controller
{
    //
    public function store(){
        $doctor = Doctor::forceCreate([
            request()->all()
        ]);
        DoctorProfile::forceCreate([
            'doctors_id' => $doctor->id
        ]);

        return response()->json([
            'message' => "Doctor has been created successfully",
            'doctor' => $doctor
        ]);
    }
    public function update(Doctor $doctor){
      if($doctor->profile->update(request()->all())){
          request()->json([
              'message' => 'Doctor updated successfully',
              'doctor' => $doctor
          ]);
      };
    }

    public function passwordReset(){

    }
}
