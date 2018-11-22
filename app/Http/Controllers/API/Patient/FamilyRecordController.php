<?php

namespace App\Http\Controllers\API\Patient;

use Illuminate\Http\Request;
use App\Models\FamilyRecord;
use App\Helpers\RecordLogger;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FamilyRecordController extends Controller
{
    //
    public function store(RecordLogger $logger){
    	$patient = auth()->guard('patient-api')->user();
    	try{
    		DB::beginTransaction();
    		$record = $logger->logMedicalRecord($patient,$patient,'family-medical-history');
   
    		$familyRecord =  FamilyRecord::forceCreate([
    			'record_id' => $record->id,
    			'disease' => request('disease'),
    			'carriers' => json_encode(request('carriers')),
    			'description' => request('description')
    		]);
    		DB::commit();
    		return response()->json([
    			'message' => 'Family Medical Record Created successfully',
    			'data' => $familyRecord
    		],200);
    	}catch(\Exception $e){
    		return response()->json([
    			'error' => $e->getMessage()
    		],400);
    	}
    }
    public function update($familyRecord){
    	$familyRecord->update([
    			'record_id' => $record->id,
    			'disease' => request('disease'),
    			'carriers' => json_encode(request('carriers')),
    			'description' => request('description')
    	]);
    	return response()->json([
    			'message' => 'Update successful',
    	],200);
    }
}
