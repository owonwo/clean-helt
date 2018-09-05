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
}
