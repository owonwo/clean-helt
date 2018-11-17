<?php

namespace App\Http\Controllers\API\Patient;

use App\Helpers\RecordLogger;
use App\Models\Immunization;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ImmunizationController extends Controller
{
    use PatientRecords;

    protected $model = Immunization::class;
    //
    public function store(RecordLogger $logger)
    {
        $patient = auth()->guard('patient-api')->user();
        //Log a medical record
        try {
            DB::beginTransaction();
            $record = $logger->logMedicalRecord($patient, $patient, 'immunization');

//            dd(request()->all());
            $immunization = Immunization::forceCreate([
                'record_id' => $record->id,
                'immunization_title' => request('immunization_title'),
                'age' => request('age'),
                'date_of_immunization' => request('date_of_immunization'),
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Immunization Record Created Successfully',
                'immunization' => $immunization->load('record'),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' =>  "Could not successfully create immunization Record",
            ], 400);
        }
        //Save the actual data
    }

    public function update(Immunization $immunization)
    {
        $data = $immunization->update([
            'immunization_title' => request('immunization_title'),
            'age' => request('age'),
            'date_of_immunization' => request('date_of_immunization'),
        ]);
        return response()->json([
            'message' => "Immunization updated successfully",
            'immunization' => $immunization->load('record'),
        ], 200);
    }
}
