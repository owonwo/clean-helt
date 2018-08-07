<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Doctor;
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

        public function index(){
            $doctors = Doctor::all();
            return $doctors;
        }

        //Show a particular doctor
        public function show(Doctor $doctor){

            return json_encode($doctor);

        }
        public function verify(Doctor $doctor){
            $doctor->update([
                'validation' => true,
            ]);
            return json_encode($doctor);
        }
        public function update(Doctor $doctor){
            $doctor->update([
               ''
            ]);

        }
        public function deactivate(Doctor $doctor){
             $doctor->profile->update([
                'active' => false
            ]);
        }
        public function activate(Doctor $doctor){
            $doctor->profile->update([
                'active' => true
            ]);

        }

}
