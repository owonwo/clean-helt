<?php

namespace App\Http\Controllers\API\Doctor;

use App\Filters\PatientFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShareExtensionResource;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Notifications\PatientToDoctorReferral;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor-api');
    }

    public function index(PatientFilter $filter)
    {
        $doctor = auth()->guard('doctor-api')->user();

        try {
            $patients = $doctor->assignedShares()
                                ->activeShares()
                                ->with('profileShare', 'sharer')
                                ->latest()
                                ->get();

            return response()->json([
                'message' => 'Patients retrieved successfully',
                'patients' => ShareExtensionResource::collection($patients),
            ], 200);
        } catch (Exception $e) {
            return response()->json([

                'error' => $e->getMessage(),

            ], 403);
        }
    }
    
    
    public function pending(PatientFilter $filter)
    {
        $doctor = auth()->guard('doctor-api')->user();

        try {
            $patients = $doctor->assignedShares()
                                ->pendingShares()
                                ->with('profileShare', 'sharer')
                                ->latest()
                                ->get();

            return response()->json([
                'message' => 'Patients retrieved successfully',
                'patients' => ShareExtensionResource::collection($patients),
            ], 200);
        } catch (Exception $e) {
            return response()->json([

                'error' => $e->getMessage(),

            ], 403);
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

    public function diagnosis(Patient $patient)
    {
        $doctor = auth()->guard('doctor-api')->user();

        if ($patient && $doctor->canViewProfile($patient)) {
            $records = $patient->medicalRecords('App\Models\Diagnosis')->get();

            $records->each(function ($record) {
                $record->data;
                $record->data->tests = json_decode($record->data->tests);
                $record->data->extras = json_decode($record->data->extras);
                $record->data->symptoms = explode(',', $record->data->symptoms);
            });

            return response()->json([
                'message' => 'Patient Diagnosis retrieved successfully',
                'records' => $records,
            ], 200);
        }

        return response()->json([
            'message' => 'Unauthorized access',
        ], 400);
    }

    public function showLabTest(Patient $patient)
    {
        $doctor = auth()->guard('doctor-api')->user();
        if ($patient && $doctor->canViewProfile($patient)) {
            return response()->json([
                'message' => 'Patient LabTest retrieved successfully',
                'labTest' => $patient->medicalRecords("App\Models\LabTest")->get()->load('data'),
            ], 200);
        }

        return response()->json([
            'message' => 'Unauthorized access',
        ], 400);
    }

    public function showMedicalRecords(Patient $patient, MedicalRecord $medicalRecord)
    {
        $doctor = auth()->guard('doctor-api')->user();
        if (!$doctor->canViewProfile($patient)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json([
            'data' => $medicalRecord->get()->each(function ($record) {
                $record->data;
            }),
        ], 200);
    }

    public function showPrescriptions(Patient $patient)
    {
        $doctor = auth()->guard('doctor-api')->user();
        if ($patient && $doctor->canViewProfile($patient)) {
            return response()->json([
                'message' => 'Patient Prescription retrieved successfully',
                'data' => $patient->medicalRecords('App\Models\Prescription')->get()->each(function ($pre) {
                    return $pre->data;
                }),
            ], 200);
        }

        return response()->json([
            'message' => 'Unauthorized access',
        ], 400);
    }
}
