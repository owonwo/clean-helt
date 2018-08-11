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
}
