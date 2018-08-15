<?php

namespace App\Http\Controllers\API\Doctor ;

use App\Http\Controllers\Controller;
use App\Models\Doctor;


class DoctorController extends Controller
{
    //
    protected $rules = [
        'first_name' => 'required|string|min:3|max:255',
        'last_name' => 'required|string|min:3|max:255',
        'middle_name' => 'required|string|min:3|max:255',
        'email' => 'required|string|email|max:255|unique:doctors',
        'password' => 'required|min:6',
        'phone' => 'required|unique:doctors',
        'gender' => 'required|string',
        'specialization' => 'required|string',
        'folio' => 'required|string',//folio is that doctors bar
    ];
    public function store(){

        request()->validate($this->rules);

        $data = request()->all();
        if($doctor = Doctor::forceCreate($data)){
            return response()->json([
                'message' => "Doctor has been created successfully",
                'doctor' => $doctor
            ],200);
        }
            return response()->json([
                'message' => "There was an error"
            ],400);
    }
    public function update(Doctor $doctor){

      if($doctor->profile->update(request()->all()) || $doctor->update(request()->all())){
         return request()->json([
              'message' => 'Doctor updated successfully',
              'doctor' => $doctor
          ],200);
      }
          return request()->json([
              'message' => "Fuck!! it failed to update",
          ],400);
    }
    public function show(Doctor $doctor){
        return response()->json([
            'message' => 'Doctors Loaded successfully',
            'doctor' => $doctor,
            'doctorProfile' => $doctor->profile,
        ]);
    }
    public function passwordReset(){

    }
}
