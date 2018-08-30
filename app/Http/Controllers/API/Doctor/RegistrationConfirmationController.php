<?php

namespace App\Http\Controllers\API\Doctor;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegistrationConfirmationController extends Controller
{
    //
    public function __construct(){
         $this->middleware('auth:doctor-api');
    }
    public function index(){

        $doctor = Doctor::where('token',request('token'))->first();
        if(!$doctor) {
            return redirect(url('/'))->with('flash','invalid token');
        }
        $doctor->confirm();
        return redirect(route('doctor.profile',$doctor))->with('flash','Your account has been confirmed');
    }

}
