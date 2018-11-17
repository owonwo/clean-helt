<?php

namespace App\Http\Controllers\API\Patient;


use App\Helpers\RecordLogger;
use App\Models\HealthInsurance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HealthInsuranceController extends Controller
{
    //
    public function store(RecordLogger $logger){
        $patient = auth()->guard('patient-api')->user();

        try{
            DB::beginTransaction();
            $record = $logger->logMedicalRecord($patient,$patient,'health-insurance');
            $healthInsurance = HealthInsurance::forceCreate([
                'record_id' => $record->id,
                'insurance_type' => request('insurance_type') ,
                'company_name' => request('company_name'),
                'address' => request('address'),
                'city' => request('city'),
                'phone' => request('phone'),
                'emergency_phone' => request('emergency_phone')
            ]);
        
            DB::commit();
            return response()->json([
                'message' => 'Health insurance provider created successfully',
                'data' => $healthInsurance->load('record')
            ],200);
        }catch (\Exception $e){
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function update(HealthInsurance $healthInsurance){
        $healthInsurance->update([
                'insurance_type' => request('insurance_type') ,
                'company_name' => request('company_name'),
                'address' => request('address'),
                'city' => request('city'),
                'phone' => request('phone'),
                'emergency_phone' => request('emergency_phone')
        ]);
        return response()->json([
            'message' => 'Health Insurance updated successfully',
            'data' => $healthInsurance->load('record')
        ]);
    }
}
