<?php

namespace App\Http\Controllers\API\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Validation\ValidationException;
use App\Helpers\RecordLogger;
use App\Models\Patient;
use App\Models\MedicalCheckup;
use DB, Storage;

class MedicalCheckupController extends Controller
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

        $records = $patient->medicalRecords("App\Models\MedicalCheckup")->get();
        
        $records->each(function($record) {
            $record->checkup = $record->data;
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
            
            $record = $logger->logMedicalRecord($patient, $doctor, 'checkup');
            
            $data = request()->only(array_keys($rules));
            $data['record_id'] = $record->id;
            $data['report'] = request('report')->store('checkups');
            
            $history = MedicalCheckup::forceCreate($data);
            
            DB::commit();

            return response()->json([
                'message' => 'Medical Checkup recorded successfully',
                'data' => $history,
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
    
    public function update(Patient $patient, MedicalCheckup $medicalCheckup)
    {
        $doctor = auth()->guard('doctor-api')->user();
        
        if (!$doctor->canViewProfile($patient))
            return response()->json(['message' => 'Unauthorized'], 401);
          
        $data = request()->all();
        
        if (request()->hasFile('report') && request()->file('report')->isValid) {
            // delete old report
            Storage::delete($medicalCheckup->getOriginal('report'));
            $data['report'] = request('report')->store('checkups');
        }
        
        if ($medicalCheckup->update($data)) 
            return response()->json(['message' => 'Update successful'], 200);
            
            
        return response()->json(['message' => 'Update Unsuccessful'], 400);
    }
    
    public function delete(Patient $patient, MedicalCheckup $medicalCheckup)
    {
        $doctor = auth()->guard('doctor-api')->user();
        
        if (!$doctor->canViewProfile($patient))
            return response()->json(['message' => 'Unauthorized'], 401);
            
        try {
            
            $medicalCheckup->record->delete();
            Storage::delete($medicalCheckup->getOriginal('report'));
            $medicalCheckup->delete();

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
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'checkup_date' => 'required|date',
            'report' => 'required|file|mimes:pdf,docx,doc'
        ];
    }
}
