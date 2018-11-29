<?php

namespace App\Http\Controllers\API\Doctor;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;

use App\Models\Patient;
use App\Models\Allergy;
use App\Helpers\RecordLogger;
use DB;

class AllergyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor-api');
    }

    public function index(Patient $patient)
    {
        $doctor = auth()->user();

        if (!$doctor->canViewProfile($patient)) 
            return response()->json(['message' => 'Unauthorized'], 401);

        $records = $patient->medicalRecords("App\Models\Allergy")->get();
        
        $records->each(function($record) {
            $record->allergy = $record->data;
        });
        
        return response()->json([
            'message' => 'Success', 
            'records' => $records
        ], 200);
    }

    public function store(Request $request, Patient $patient, RecordLogger $logger)
    {
        $doctor = auth()->user();

        if (!$doctor->canViewProfile($patient)) 
            return response()->json(['message' => 'Unauthorized'], 401);

        $rules = $this->getValidationRules();

        try {
            $this->validate($request, $rules);

            DB::beginTransaction();

            $record = $logger->logMedicalRecord($patient, $doctor, 'allergy');

            $data = $request->only(array_keys($rules));
            $data['record_id'] = $record->id;

            $allergy = $record->data()->create($data);
            
            DB::commit();

            return response()->json([
                'message' => 'Allergy created successfully',
                'allergy' => $allergy,
                'record' => $record
            ], 200);
        } catch(ValidationException $e) {
            DB::rollback();
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request, Patient $patient, Allergy $allergy)
    {
        $doctor = auth()->user();

        if (!$doctor->canViewProfile($patient)) 
            return response()->json(['message' => 'Unauthorized'], 401);

        if ($allergy->update($request->all())) {
            return response()->json(['message' => 'Update successful', 'allergy' => $allergy->fresh()], 200);
        }

        return response()->json(['message' => 'Update failed'], 400);
    }

    public function delete(Patient $patient, Allergy $allergy)
    {
        $doctor = auth()->user();

        if (!$doctor->canViewProfile($patient)) 
            return response()->json(['message' => 'Unauthorized'], 401);
        
        try {
            $record = $allergy->record;
            $allergy->delete();
            $record->delete();
            return response()->json(['message' => 'Deleted successfully'], 200);
        } catch(Exception $e) {
            return response()->json(['message' => "Error: " . $e->getMessage()], 400);
        }
    }

    private function getValidationRules()
    {
        return [
            'allergy' => 'required',
            'reaction' => 'required',
            'last_occurance' => 'required|date',
        ];
    }
}
