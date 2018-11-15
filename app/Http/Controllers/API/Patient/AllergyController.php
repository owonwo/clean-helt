<?php

namespace App\Http\Controllers\API\Patient;

use App\Helpers\RecordLogger;
use App\Models\Allergy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AllergyController extends Controller
{
    //
    public function store(RecordLogger $logger){
        $patient = auth()->guard('patient-api')->user();
        try{
            DB::beginTransaction();
            $record = $logger->logMedicalRecord($patient,$patient,"allergy");
            $allergy = Allergy::forceCreate([
                "record_id" => $record->id,
                "allergy" => request("allergy"),
                "reaction" => request("reaction"),
                "last_occurance" => request("last_occurance")
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Allergy has been created successfully',
                'data' => $allergy
            ],200);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function update(Allergy $allergy){
        $allergy->update([
            "allergy" => request("allergy"),
            "reaction" => request("reaction"),
            "last_occurance" => request("last_occurance")
        ]);
        return response()->json([
            "message" => "Allergy updated successfully",
            "allergy" => $allergy->load('record')
        ],200);
    }
}
