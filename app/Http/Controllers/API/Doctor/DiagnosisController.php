<?php

namespace App\Http\Controllers\API\Doctor;

use App\Helpers\RecordLogger;
use App\Models\Diagnosis;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DiagnosisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor-api');
    }

    public function store(Request $request, Patient $patient, RecordLogger $logger)
    {
        $rules = $this->getRules();

        $this->validate($request, $rules);

        $doctor = auth()->guard('doctor')->user();
        if ($patient && $doctor->canViewProfile($patient)) {
            try {
                DB::beginTransaction();
                //Step 1: log a medical record
                $record = $logger->logMedicalRecord($patient, $doctor, 'diagnosis');

                //Step 2: Save the actual data
                $data = $request->only(array_keys($rules));
                $data['record_id'] = $record->id;
                $diagnosis = Diagnosis::create($data);

                //TODO
                //Step 3: Check if there are prescriptions and tests and save them

                DB::commit();
                return response()->json([
                    'message' => 'Diagnosis made successfully',
                    'diagnosis' => $diagnosis->load('record')
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                dd($e->getMessage());
                return response()->json([
                    'message' => 'Diagnosis creation failed. ' . $e->getMessage()
                ], 400);
            }
        }

        return response()->json([
            'message' => 'Unauthorized access'
        ], 400);
    }

    private function getRules()
    {
        return [
            'complaint_relationship' => 'nullable|string',
            'complaint_history' => 'nullable|string',
            'patient_condition' => 'required',
            'symptoms' => 'nullable',
            'extras' => 'nullable',
            'comments' => 'required|string'
        ];
    }
}
