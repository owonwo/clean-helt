<?php

namespace App\Http\Controllers\API\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Validation\ValidationException;
use App\Helpers\RecordLogger;
use App\Models\Patient;
use App\Models\Medication;
use DB;

class MedicationController extends Controller
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

        $records = $patient->medicalRecords("App\Models\Medication")->get();
        
        $records->each(function($record) {
            $record->history = $record->data;
        });
        
        return response()->json([
            'message' => 'Success', 
            'records' => $records
        ], 200);
    }
    
    public function store(Patient $patient, RecordLogger $logger)
    {
        $doctor = auth()->guard('doctor-api')->user();
        
        if (!$doctor->canViewProfile($patient))
            return response()->json(['message' => 'Unauthorized'], 401);
        
        try {
            $rules = $this->getRules();
            $this->validate(request(), $rules);
                
            DB::beginTransaction();
            
            $record = $logger->logMedicalRecord($patient, $doctor, 'medications');
            
            $data = request()->only(array_keys($rules));
            $data['record_id'] = $record->id;
            
            $medication = Medication::forceCreate($data);
            
            DB::commit();

            return response()->json([
                'message' => 'Medication added successfully',
                'data' => $medication,
            ], 200);
            
        } catch(ValidationException $e) {
         
            DB::rollback();
            return response()->json([
                'errors' => $e->errors(),
                'message' => $e->getMessage(),
            ], 422);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    
    public function update(Patient $patient, Medication $medication)
    {
        $doctor = auth()->guard('doctor-api')->user();
        
        if (!$doctor->canViewProfile($patient))
            return response()->json(['message' => 'Unauthorized'], 401);
          
        $data = request()->all();
        
        if ($medication->update($data)) 
            return response()->json(['message' => 'Update successful'], 200);
            
            
        return response()->json(['message' => 'Update Unsuccessful'], 400);
    }
    
    public function delete(Patient $patient, Medication $medication)
    {
        $doctor = auth()->guard('doctor-api')->user();
        
        if (!$doctor->canViewProfile($patient))
            return response()->json(['message' => 'Unauthorized'], 401);
            
        try {
            
            $medication->record->delete();
            $medication->delete();

            return response()->json([
                'message' => 'Delete successful',
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
    
    private function getRules()
    {
        return [
            'name' => 'required|string',
            'date' => 'required|date',
            'frequency' => 'required',
            'dosage' => 'required'
        ];
    }
}
