<?php

namespace App\Http\Controllers\API\Hospital;

use App\Models\Doctor;
use App\Models\ProfileShare;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    private $hospital;

    public function __construct()
    {
        $this->middleware('auth:hospital-api');
        $this->middleware(function($request, $next) {

            $this->hospital = auth()->user();

            return $next($request);
        });
    }

    public function index()
    {
        return response()->json([
            'message' => 'Patients retrieved successfully',
            'patients' => $this->hospital->patients()->get()
        ], 200);
    }

    public function assign(ProfileShare $profileShare, Doctor $doctor)
    {
        if(!$profileShare->exists && !$this->hospital->canViewProfile($profileShare->patient))
            return response()->json(['message' => 'Patient not found'], 404);

        if(!$doctor->exists && !$this->hospital->isActiveDoctor($doctor))
            return response()->json(['message' => 'Doctor not found'], 404);

        if ($profileShare->update(['doctor_id' => $doctor->id])) {
            return response()->json([
                'message' => 'Patient assigned to doctor successfully'
            ], 200);
        }

        return response()->json([
            'message' => 'Patient could not be assigned'
        ], 400);
    }
    
    public function assignMultiple(Request $request, ProfileShare $profileShare)
    {
        if(!$profileShare->exists && !$this->hospital->canViewProfile($profileShare->patient))
            return response()->json(['message' => 'Patient not found'], 404);
            
        $doctorCodes = $request->doctor_codes ?? [];
        
        $assigned = $failed = [];
        
        foreach($doctorCodes as $code) {
            $doctor = Doctor::whereChcode($code)->first();
            if (!$doctor && !$this->hospital->isActiveDoctor($doctor)) {
                $failed[$code] = 'Doctor not found';
                continue;
            }
            
            // check if doctor already has access to profile
            if ($doctor->canViewProfile($profileShare->patient))
                continue;
            
            $share = $profileShare->extensions()->create([
                'sharer_id' => $this->hospital->id,
                'sharer_type' => get_class($this->hospital),
                'provider_id' => $doctor->id,
                'provider_type' => get_class($doctor),
                'expired_at' => $profileShare->expired_at,
                'status' => "1"
            ]);
            
            if ($share) $assigned[] = $code;
            else $failed[$code] = "An error occurred";
            
        }


        return response()->json([
            'message' => 'Assignments done',
            'failed' => $failed,
            'assigned' => $assigned
        ], 200);
    }
    
    public function unassign(ProfileShare $profileShare, Doctor $doctor)
    {
        $shareExtension = $profileShare->extensions()
                                ->where('provider_type', get_class($doctor))
                                ->where('provider_id', $doctor->id)
                                ->first();
                                
        if ($shareExtension && $shareExtension->delete()) {
            return response()->json([
                'message' => 'Doctor successfully removed from patient'
            ], 200);
        }
        
        return response()->json(['message' => 'Doctor could not be unassigned.'], 400);
    }
    
}
