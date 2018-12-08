<?php

namespace App\Http\Controllers\API\Patient;

use App\Helpers\RecordLogger;
use App\Models\EmergencyContact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EmergencyContactController extends Controller
{
    //
    use PatientRecords;
    protected $model = EmergencyContact::class;
    public function store(RecordLogger $logger){
        $patient = auth()->guard('patient-api')->user();
        try{
            DB::beginTransaction();
            $record = $logger->logMedicalRecord($patient, $patient, 'hospital-contact');
            $emergencyContact =  EmergencyContact::forceCreate(array_merge(request()->all(),['record_id' => $record->id]));
            DB::commit();
            return response()->json([
                'message' => 'Hospital Contact Successfully created',
                'data' => $emergencyContact->load('record')
            ],200);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong'
            ],400);
        }
    }
    public function update(EmergencyContact $emergencyContact){
        $emergencyContact->update(request()->all());

        return response()->json([
            'message' => 'Emergency contact created successful',
            'data' => $emergencyContact->fresh()
        ]);
    }
}
