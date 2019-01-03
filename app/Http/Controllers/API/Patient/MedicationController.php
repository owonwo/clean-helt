<?php

namespace App\Http\Controllers\API\Patient;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\RecordLogger;
use App\Models\Medication;
use Illuminate\Support\Facades\DB;


class MedicationController extends Controller
{
    use PatientRecords;

    protected $model = Medication::class;

    public function store(RecordLogger $logger)
    {
        $patient = auth()->guard('patient-api')->user();

        try {
            
            $rules = $this->getRules();
            
            DB::beginTransaction();
            
            $record = $logger->logMedicalRecord($patient, $patient, 'medications');
            
            $data = request()->only(array_keys($rules));
            $data['record_id'] = $record->id;
            
            $medication =  Medication::forceCreate($data);
            
            
            DB::commit();

            return response()->json([
                'message' => 'Medication added successfully',
                'data' => $medication->load('record'),
            ], 200);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
    
    public function update(Medication $medication)
    {
        $medication->update(request()->only(array_keys($this->getRules())));

        return response()->json([
            'message' => 'Update Successful',
            'data' => $medication->fresh(),
        ], 200);
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
