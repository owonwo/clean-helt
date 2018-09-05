<?php

namespace App\Http\Controllers\API\Doctor;

use App\Helpers\RecordLogger;
use App\Models\Diagnosis;
use App\Models\LabTest;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Prescription;
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
        $doctor = auth()->guard('doctor-api')->user();

        if ($patient && $doctor->canViewProfile($patient)) {
            try {
                DB::beginTransaction();
                //Step 1: log a medical record
                $record = $logger->logMedicalRecord($patient, $doctor, 'diagnosis');

                //Step 2: Save the actual data
                $data = $request->only(array_keys($rules));
                $data['record_id'] = $record->id;
                $diagnosis = Diagnosis::forceCreate($data);

                //TODO
                //Step 3: Check if there are prescriptions and tests and save them
                if($request->input('prescription') && $request->input('test')){
                    $this->createPrescriptions($record->id,null,$diagnosis->id);
                    $this->createLabTest($record->id,$diagnosis->id);
                }
               DB::commit();

                /**
                 * @Todo here
                 * please add a notification that after creating the medical record
                 * it sent a notification to the user
                 */

                return response()->json([
                    'message' => 'Diagnosis made successfully',
                    'diagnosis' => $diagnosis->load('record')
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();
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
    private function createPrescriptions($record,$pharmacy = null,$diagnosis){
            Prescription::forceCreate([
                'record_id' => $record,
                'quantity' => request('quantity'),
                'frequency' => request('frequency'),
                'name' => request('name'),
                'pharmacy_id' => $pharmacy,
                'diagnosis_id' => $diagnosis
            ]);
    }
    private function createLabTest($record,$diagnosis){
             LabTest::forceCreate([
               'record_id' => $record,
                'name' => request('test_name'),
                'description' => request('description'),
                'result' => request('result'),
                'conclusion' => request('conclusion'),
                'status' => request('status'),
                'taker' => request('taker'),
                'diagnosis_id' => $diagnosis
            ]);
    }
}
