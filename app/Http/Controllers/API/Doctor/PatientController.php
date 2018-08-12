<?php

namespace App\Http\Controllers\API\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index()
    {
        $doctor = auth()->guard('doctor')->user();

        $patients = $doctor->profileShares()
                        ->activeShares()
                        ->with('patient')
                        ->get();

        return response()->json([
            'message' => 'Patients retrieved successfully',
            'patients' => $patients
        ], 200);
    }

    public function show(Patient $patient)
    {
        $doctor = auth()->guard('doctor')->user();
        if ($patient && $doctor->canViewProfile($patient)) {
            return response()->json([
                'message' => 'Patient retrieved successfully',
                'patient' => $patient
            ], 200);
        }

        return response()->json([
            'message' => 'Unauthorized access'
        ], 400);
    }
}
