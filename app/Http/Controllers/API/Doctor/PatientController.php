<?php

namespace App\Http\Controllers\API\Doctor;

use App\Filters\PatientFilter;
use App\Models\Doctor;
use App\Models\ProfileShare;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function __construct()
    {
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
                'patients' => $patients,
            ], 200);
        } catch (Exception $e) {
            return response()->json([

                'error' => $e->getMessage(),

            ], 403);
        }
    }


    public function refer(Patient $patient)
    {
        $doctor = auth()->guard('doctor-api')->user();
        if ($doctor->hospitals() && request()->has('hospital')) {
            foreach ($doctor->hospitals()->get() as $hospital) {
                if (request('hospital') == $hospital->chcode) {
                    $hospitalDoctors = $hospital->doctors()->get();
                    foreach ($hospitalDoctors as $hospitalDoctor) {
                        if (request('chcode') == $hospitalDoctor->chcode) {
                            $this->doctorReferral($doctor, $patient, $hospitalDoctor);
                        }
                    }
                }
            }
            return response()->json([
                "message" => "Profile Referred successfully"
            ]);
        } else {
            $chcode = request('chcode');
            $refferedDoctor = Doctor::whereChcode($chcode)->get()->first();
            $this->doctorReferral($doctor, $patient, $refferedDoctor);
        }
    }


    public function doctorReferral($doctor,$patient,$refferedDoctor){
            $provider_type ='App\Models\Doctor';
            //Doctor places in the chcode of another doctor
            $chcode = request('chcode');
            if($doctor->canViewProfile($patient)){
                $patient->profileShares()->create([
                    'provider_type' => $provider_type,
                    'provider_id' => $refferedDoctor->id,
                    'expired_at' => request('expiration'),
                ]);
                return response()->json([
                    'message' => "You have successfully referred ".$refferedDoctor->first_name. "to " . $patient->first_name
                ],200);
            } else{
                return response()->json([
                    'message' => 'This doctor cannot share this patient'
                ],400);
            }
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

    public function showLabTest(Patient $patient)
    {
        $doctor = auth()->guard('doctor-api')->user();
        if ($patient && $doctor->canViewProfile($patient)) {
            return response()->json([
                'message' => 'Patient LabTest retrieved successfully',
                'labTest' => $patient->medicalRecords('App\Models\LabTest')->get()->load('data'),
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
        die('');

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
                'prescriptions' => $patient->medicalRecords('App\Models\Prescription')->get()->load('data'),
            ], 200);
        }

        return response()->json([
            'message' => 'Unauthorized access',
        ], 400);
    }
}
