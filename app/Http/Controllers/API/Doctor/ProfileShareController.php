<?php

namespace App\Http\Controllers\API\Doctor;

use App\Models\ProfileShare;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileShareController extends Controller
{
    public function __construct(){
         $this->middleware('auth:doctor-api');
    }
    //
    public function pending(){
        $doctor =  auth()->guard('doctor')->user();
        $pendingPatients = ProfileShare::where([['provider_id', optional($doctor)->id],['status','=','0']])->get();

        if($pendingPatients){
             return response()->json([
            'message' => 'All Pending patients loaded',
            'pendingPatients' => $pendingPatients
             ]);
        } 
             return response()->json([
                'message' => 'Shit!! get outta here'
             ],403);
       
        //select all pending request for a particular provider and view them

        //steps one check the get the provider->id and use it to get all his patients and check his status column
    }

    public function accept(ProfileShare $profileShare)
    {
        if($profileShare->exists && $profileShare->update(['status' => 1])){

            return response()->json([
                'message' => 'Profile share has been accepted',
                'profileShare' => $profileShare
            ]);
        }
        return response()->json([
            'message' => 'Profile share acceptance failed'
        ]);
    }

    public function decline(ProfileShare $profileShare)
    {
        if($profileShare->update(['status' => 2])){
            return response()->json([
                'message' => 'Profile share has been accepted',
                'profileShare' => $profileShare
            ]);
        }
        return response()->json([
            'message' => 'Profile share acceptance failed'
        ]);
    }
}
