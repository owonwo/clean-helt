<?php

namespace App\Http\Controllers\API\Doctor;

use App\Filters\PatientFilter;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;

class PatientController extends Controller
{
    public function __construct(){
         $this->middleware('auth:doctor-api');
    }
    public function index(PatientFilter $filter)
    {

        $doctor = auth()->guard('doctor-api')->user();
        $start = request('startDate');
        $end = request('endDate');
        try {
            $patients = optional($doctor->profileShares(), function ($doctor) use ($end, $start, $filter) {
                return $doctor->filter($filter, $filter->dateRange($start, $end))
                    ->activeShares()
                    ->with('patient')
                    ->get();
            });

            return response()->json([
                'message' => 'Patients retrieved successfully',
                'patients' => $patients
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ],403);
        }

    }

    public function show(Patient $patient)
    {
        $doctor = auth()->guard('doctor-api')->user();
        if ($patient && $doctor->canViewProfile($patient)) {
            return response()->json([
                'message' => 'Patient retrieved successfully',
                'patient' => $patient,
            ], 200);
        }

        return response()->json([
            'message' => 'Unauthorized access',
        ], 400);
    }
}
