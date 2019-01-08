<?php

namespace App\Http\Controllers\API\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MedicalRecord;
use App\Helpers\RecordLogger;


class MedicalRecordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:patient-api');
    }
    
    public function index(RecordLogger $logger)
    {
        $type = request('type');
        
        $query = MedicalRecord::query();
        
        
        if ($type) {
            
            $query = $query->where('type', $logger->getRecordType($type));    
            
        }
        
        $records = $query->where('patient_id', auth()->id())->latest()->get();
        
        // Attach data
        $records->each(function($record) {
            $record->data = $record->data;
        });
        
        return response()->json([
            'message' => 'Success', 
            'records' => $records
        ], 200);
    }
}
