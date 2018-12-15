<?php

namespace App\Http\Controllers\API\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\RecordLogger;
use App\Models\Patient;
use App\Models\Hospitalize;
use DB;

class HospitalizationController extends Controller
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

        $records = $patient->medicalRecords("App\Models\Hospitalize")->get();
        
        $records->each(function($record) {
            $record->hospitalization = $record->data;
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
            
            $record = $logger->logMedicalRecord($patient, $doctor, 'hospitalization');
            
            $hospitalization = Hospitalize::forceCreate([
                'record_id' => $record->id,
                'hospitalization_type' => request('hospitalization_type'),
                'hospital' => request('hospital'),
                'doctor' => request('doctor'),
                'reason' => request('reason'),
                'complications' => request('complications'),
            ]);
            
            DB::commit();

            return response()->json([
                'message' => 'Hospitalization created successfully',
                'data' => $hospitalization->load('record'),
            ], 200);
            
        } catch (\Exception $e) {
            
            DB::rollback();

            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
    
    public function update(Patient $patient, Hospitalize $hospitalize)
    {
        $doctor = auth()->guard('doctor-api')->user();
        
        if (!$doctor->canViewProfile($patient))
            return response()->json(['message' => 'Unauthorized'], 401);
        
        $update = request()->all();
       
        if ($hospitalize->update($update)) {
            return response()->json([
                'message' => 'Hospitalization updated successfully',
                'data' => $hospitalize->fresh()->load('record'),
            ], 200);    
        }
        
        return response()->json(['message' => 'Update Unsuccessful'], 400);
    }
    
    
    public function delete(Patient $patient, Hospitalize $hospitalize)
    {
        $doctor = auth()->guard('doctor-api')->user();
        
        if (!$doctor->canViewProfile($patient))
            return response()->json(['message' => 'Unauthorized'], 401);
            
        try {
            
            $hospitalize->record->delete();
            $hospitalize->delete();

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
