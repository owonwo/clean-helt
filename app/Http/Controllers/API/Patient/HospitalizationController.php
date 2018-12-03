<?php

namespace App\Http\Controllers\API\Patient;

use App\Helpers\RecordLogger;
use App\Http\Controllers\Controller;
use App\Models\Hospitalize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HospitalizationController extends Controller
{
    use PatientRecords;

    protected $model = Hospitalize::class;

    public function store(RecordLogger $logger)
    {
        $patient = auth()->guard('patient-api')->user();

        try {
            DB::beginTransaction();
            $record = $logger->logMedicalRecord($patient, $patient, 'hospitalization');
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
    public function update(Hospitalize $hospitalize)
    {
        $hospitalize->update([
                'hospitalization_type' => request('hospitalization_type'),
                'hospital' => request('hospital'),
                'doctor' => request('doctor'),
                'reason' => request('reason'),
                'complications' => request('complications'),
        ]);

        return response()->json([
            'message' => 'Hospitalization updated successfully',
            'data' => $hospitalize->load('record'),
        ]);
    }
}
