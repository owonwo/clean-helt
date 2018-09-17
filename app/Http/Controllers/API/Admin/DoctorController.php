<?php

namespace App\Http\Controllers\API\Admin;

use App\Events\VerifyDoctor;
use App\Models\Doctor;
use App\Http\Controllers\Controller;
class DoctorController extends Controller
{
    //
        public function __construct()
        {
            $this->middleware('auth:admin-api');
        }

        public function index()
        {
            $doctors = Doctor::paginate(10);
            return response()->json([
                'message' => 'Doctor fetched successfully',
                'doctors' => $doctors
            ], 200);
        }

        //Show a particular doctor
        public function show(Doctor $doctor){
            return response()->json([
                'message' => 'Doctor fetched successfully',
                'doctor' => $doctor
            ], 200);
        }

        public function verify(Doctor $doctor){
            $doctor->update([
                'validation' => true,
            ]);
            //Send Email that doctor has been verified
            event(new VerifyDoctor($doctor));
            return json_encode($doctor);
        }
        public function update(Doctor $doctor){
            if ($doctor->update(request()->all())) {
                return response()->json([
                    'message' => 'Doctor updated successfully',
                    'doctor' => $doctor
                ], 200);
            }

        }

        public function destroy(Doctor $doctor){
            $doctor->delete();
        }

        public function deactivate(Doctor $doctor){
             $doctor->profile->update([
                 'active' => false,
             ]);

            return response()->json([
                'doctor' => $doctor,
                'message' => 'Deactivated successfully'
            ]);
        }
        public function activate(Doctor $doctor){

            $doctor->profile->update([
                'active' => true
            ]);
            return response()->json([
                'doctor' => $doctor,
                'message' => 'Activated successfully'
            ]);

        }

}
