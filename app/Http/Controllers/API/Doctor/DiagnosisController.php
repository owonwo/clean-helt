<?php

namespace App\Http\Controllers\API\Doctor;

use App\Helpers\RecordLogger;
use App\Models\Diagnosis;
use App\Models\LabTest;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Prescription;
use App\Notifications\PatientMedicalRecordsNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class DiagnosisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor-api');
    }

    public function store(Request $request, Patient $patient, RecordLogger $logger)
    {
       $rules = $this->getRules();

        Log::info(['request' => $request->prescriptions]);


        try {
            $this->validate($request, $rules);
        } catch (ValidationException $exception) {
            return response()->json([
                'errors' => $exception->errors(),
                'message' => $exception->getMessage(),
            ], 422);
        }

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

                $patient->notify(new PatientMedicalRecordsNotification($diagnosis, $patient));

                //TODO
                //Step 3: Check if there are prescriptions and tests and save them
                if($request->prescriptions){
                    
                    $this->createPrescriptions($record->id,null,$diagnosis->id);
                    
                    Log::info(['request' => $request->all()]);
                }
                if($request->tests){
                    $this->createLabTest($record->id,$diagnosis->id);
                }
               DB::commit();

                /**
                 * @Todo here
                 * please add a notification that after creating the medical record
                 * it sent a notification to the user
                 */
                //am working here

                

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
        ], 401);
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
        
        foreach(request('prescriptions') as $prescription){
            Prescription::forceCreate([
                'record_id' => $record,
                'quantity' =>$prescription['quantity'],
                'frequency' => $prescription['frequency'],
                'name' => $prescription['name'],
                'pharmacy_id' => $pharmacy,
                'diagnosis_id' => $diagnosis
            ]); 
        }
      
    }
    private function createLabTest($record,$diagnosis){
            foreach(request('tests') as $test){
                LabTest::forceCreate([
                    'record_id' => $record,
                    'test_name' => $test['test_name'],
                    'description' => $test['description'],
                    'result' => $test['result'],
                    'conclusion' => $test['conclusion'],
                    'status' => $test['status'],
                    'taker' => $test['taker'],
                    'diagnosis_id' => $diagnosis
                ]);
            }
    }
}
