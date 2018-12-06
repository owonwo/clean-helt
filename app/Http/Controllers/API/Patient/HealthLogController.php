<?php

namespace App\Http\Controllers\API\Patient;

use App\Helpers\RecordLogger;
use App\Models\HealthLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HealthLogController extends Controller
{
    //
    public function store(RecordLogger $logger){
        $patient = auth()->guard('patient-api')->user();

        try{
            DB::beginTransaction();
            $record = $logger->logMedicalRecord($patient, $patient, 'health-log');
            $healthLog =  HealthLog::forceCreate([

            ]);
        }catch(\Exception $e){

        }
    }
}
