<?php

namespace App\Http\Controllers\Admin;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
    //
        public function __construct()
        {
            $this->middleware('aut');
        }

        public function index(){
            $doctors = Doctor::all();
        }

        //First shows list of Doctors not verified by their latest order
        public function show($id){
            $doctors = Doctor::find($id);

        }

}
