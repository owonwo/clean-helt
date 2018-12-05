<?php

namespace App\Http\Controllers\API\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Patient;
use App\Models\Immunization;
use App\Helpers\RecordLogger;

use DB;

class ImmunizationController extends Controller
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

        $records = $patient->medicalRecords("App\Models\Immunization")->get();
        
        $records->each(function($record) {
            $record->immunization = $record->data;
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

            $record = $logger->logMedicalRecord($patient, $doctor, 'immunization');

            $data = $request->only(array_keys($rules));
            $data['record_id'] = $record->id;

            $immunization = $record->data()->create($data);
            
            DB::commit();

            return response()->json([
                'message' => 'Immunization created successfully',
                'immunization' => $immunization,
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

    public function update(Request $request, Patient $patient, Immunization $immunization)
    {
        $doctor = auth()->user();

        if (!$doctor->canViewProfile($patient)) 
            return response()->json(['message' => 'Unauthorized'], 401);

        if ($immunization->update($request->all())) {
            return response()->json(['message' => 'Update successful', 'immunization' => $immunization->fresh()], 200);
        }

        return response()->json(['message' => 'Update failed'], 400);
    }

    public function delete(Patient $patient, Immunization $immunization)
    {
        $doctor = auth()->user();

        if (!$doctor->canViewProfile($patient)) 
            return response()->json(['message' => 'Unauthorized'], 401);
        
        try {
            $record = $immunization->record;
            $immunization->delete();
            $record->delete();
            return response()->json(['message' => 'Deleted successfully'], 200);
        } catch(Exception $e) {
            return response()->json(['message' => "Error: " . $e->getMessage()], 400);
        }
    }

    private function getValidationRules()
    {
        return [
            'immunization_title' => 'required',
            'date_of_immunization' => 'required|date',
            'age' => 'required|numeric',
        ];
    }
}
