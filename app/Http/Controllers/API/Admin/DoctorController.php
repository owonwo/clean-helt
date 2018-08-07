<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Doctor;
use App\Models\DoctorProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\Comment\Doc;

class DoctorController extends Controller
{
    //
        public function __construct()
        {
            $this->middleware('auth:admin-api');
        }

        public function index()
        {
            $doctors = Doctor::all();
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
            return json_encode($doctor);
        }
        public function update(Doctor $doctor){
            if ($doctor->update(request()->all())) {
                return response()->json([
                    'message' => 'Doctor updated successfully',
                    'hospital' => $doctor
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
