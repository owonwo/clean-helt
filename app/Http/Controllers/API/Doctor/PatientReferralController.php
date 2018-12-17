<?php

namespace App\Http\Controllers\API\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ShareExtension;
use App\Models\Doctor;

class PatientReferralController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor-api');
    }
    
    public function getEligibleDoctors(ShareExtension $shareExtension)
    {
        $authDoctor = auth()->user();
        // Get a patient's share extension
        
        // Get extensions original share
        $profileShare = $shareExtension->profileShare;
        // Get the hospital from the original share
        if (!$profileShare || $profileShare->provider_type !== "App\Models\Hospital")
            $doctors = [];
        // return doctors in hospital except currently logged in doctor
        else {
            $hospital = $profileShare->provider;
            $doctors = $hospital->activeDoctors()
                                ->where('doctors.id', '!=', $authDoctor->id)
                                ->get();
        }
        
        return response()->json([
            'doctors' => $doctors
        ], 200);
    }
    
    public function referPatient(ShareExtension $shareExtension, Doctor $doctor)
    {
        // create a new share extension. Still maintains link to original
        //profile share
        $authDoctor = auth()->user();
        
        if ($shareExtension->provider->chcode !== $authDoctor->chcode)
            return response()->json(['message' => 'Unauthorized'], 401);
            
        $profileShare = $shareExtension->profileShare;
        
        if (
            $profileShare->extensions()
                ->where('provider_id', $doctor->id)
                ->where('provider_type', get_class($doctor))
                ->count() > 0
        )
            return response()->json([
                'message' => 'Doctor already has access to client'
            ], 201);
            
        $data = [
            'share_id' => $profileShare->id,
            'sharer_id' => $authDoctor->id,
            'sharer_type' => get_class($authDoctor),
            'provider_id' => $doctor->id,
            'provider_type' => get_class($doctor),
            'expired_at' => $profileShare->expired_at,
            'type' => 'referral',
            'status' => '0'
        ];
        
        // new share extension's got to be kept pending to allow patient to approve/deny
        $extension = ShareExtension::create($data);
        
        if ($extension) {
            return response()->json([
                'message' => "Patient profile shared to $doctor->chcode. Pending patient approval",
                'share' => $extension->load('profileShare')
            ], 200);
        }
        
        return response()->json([
            'message' => "Patient profile could not be shared"
        ], 400);
    }
}
