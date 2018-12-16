<?php

namespace App\Http\Controllers\API\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\FamilyRecord;
use App\Models\Doctor;
use App\Models\Patient;
use App\Helpers\RecordLogger;
use DB;

class FamilyRecordController extends Controller
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

        $records = $patient->medicalRecords("App\Models\FamilyRecord")->get();
        
        $records->each(function($record) {
            $record->family_record = $record->data;
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
            
            DB::beginTransaction();
            
            $record = $logger->logMedicalRecord($patient, $doctor, 'family-medical-history');
            
         
            $familyRecord = FamilyRecord::forceCreate([
                'record_id' => $record->id,
                'disease' => request('disease'),
                'description' => request('description'),
                'carriers' => json_encode(request('carriers')),
            ]);
            
            DB::commit();

            return response()->json([
                'message' => 'Family Medical Record Created successfully',
                'data' => $familyRecord,
            ], 200);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    
    public function update(Patient $patient, FamilyRecord $familyRecord)
    {
        $doctor = auth()->guard('doctor-api')->user();
        
        if (!$doctor->canViewProfile($patient))
            return response()->json(['message' => 'Unauthorized'], 401);
            
        $data = request()->all();
        
        if (isset($data['carriers'])) {
            $data['carriers'] = json_encode($data['carriers']);
        } else if (is_array($familyRecord->carriers)) {
            $data['carriers'] = json_encode($familyRecord->carriers);
        }
        
        if ($familyRecord->update($data)) 
            return response()->json(['message' => 'Update successful'], 200);
            
            
        return response()->json(['message' => 'Update Unsuccessful'], 400);
    }
    
    public function delete(Patient $patient, FamilyRecord $familyRecord)
    {
        $doctor = auth()->guard('doctor-api')->user();
        
        if (!$doctor->canViewProfile($patient))
            return response()->json(['message' => 'Unauthorized'], 401);
            
        try {
            
            $familyRecord->record->delete();
            $familyRecord->delete();

            return response()->json([
                'message' => 'Delete successful',
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
