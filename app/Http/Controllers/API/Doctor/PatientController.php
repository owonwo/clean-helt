<?php

namespace App\Http\Controllers\API\Doctor;

use App\Filters\PatientFilter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index(PatientFilter $filter)
    {
        $doctor = auth()->guard('doctor-api')->user();
        $start = request('startDate');
        $end = request('endDate');
        $patients = $doctor->profileShares()->filter($filter,$filter->dateRange($start,$end))
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
        $doctor = auth()->guard('doctor-api')->user();
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
