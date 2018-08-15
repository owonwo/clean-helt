<?php

namespace App\Http\Controllers\API\Doctor;

use App\Models\ProfileShare;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileShareController extends Controller
{
    //
    public function pending(){
        $doctor =  auth()->guard('doctor')->user();
        $pendingPatients = ProfileShare::where([['provider_id', $doctor->id],['status','=','0'],['']])->get();

        return response()->json([
            'message' => 'All Pending patients loaded',
            'pendingPatients' => $pendingPatients
        ]);
        //select all pending request for a particular provider and view them

        //steps one check the get the provider->id and use it to get all his patients and check his status column
    }
    public function accept(ProfileShare $profileShare)
    {
        dd($profileShare);
            if($profileShare->update(['status' => request('accept')])){
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
        if($profileShare->update(['status' => request('decline')])){
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
