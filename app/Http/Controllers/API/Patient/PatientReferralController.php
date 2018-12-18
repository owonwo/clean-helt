<?php

namespace App\Http\Controllers\API\Patient;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ShareExtension;

class PatientReferralController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:patient-api');
    }
    
    public function index()
    {
        $patient = auth()->user();
        
        $profileShares = $patient->profileShares;
        
        $shares = [];
        
        foreach($profileShares as $share) {
            $extensions = $share->extensions()->get()->toArray();
            $shares = array_merge($shares, $extensions);
        }
        
        return response()->json([
            'data' => $shares
        ], 200);
        
    }
    
    public function approveReferral(ShareExtension $shareExtension)
    {
        $patient = auth()->user();
        
        if (!$shareExtension->exists && $patient->id != $shareExtension->profileShare->patient_id)
            return response()->json(['message' => 'Unauthorized'], 401);
    
        if ($shareExtension->update(['status' => '1'])) {
            return response()->json([
                'message' => 'Referral approved successfully'
            ], 200);
        }
        
        return response()->json([
            'message' => 'Referral could not be approved at this time. Please try again later'
        ], 400);
    }
    
    public function declineReferral(ShareExtension $shareExtension)
    {
        if (!$shareExtension->exists && $patient->id != $shareExtension->profileShare->patient_id)
            return response()->json(['message' => 'Unauthorized'], 401);
            
        if ($shareExtension->update(['status' => '2'])) {
            return response()->json([
                'message' => 'Referral declined successfully'
            ], 200);
        }
        
        return response()->json([
            'message' => 'Referral could not be declined at this time. Please try again later'
        ], 400);
    }
}
