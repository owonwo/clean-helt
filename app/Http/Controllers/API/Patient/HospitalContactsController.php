<?php

namespace App\Http\Controllers\API\Patient;

use App\Helpers\RecordLogger;
use App\Models\HospitalContacts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HospitalContactsController extends Controller
{
    //
    use PatientRecords;
    protected $model = HospitalContacts::class;
    public function store(RecordLogger $logger)
    {
        $patient = auth()->guard('patient-api')->user();

        try {
            DB::beginTransaction();
            $record = $logger->logMedicalRecord($patient, $patient, 'hospital-contact');
            $hospitalContact = HospitalContacts::forceCreate(array_merge(request()->all(), ['record_id' => $record->id]));
            DB::commit();

            return response()->json([
                'message' => 'Hospital Contact Successfully created',
                'data' => $hospitalContact->load('record'),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something wen wrong',
            ], 400);
        }
    }

    public function update(HospitalContacts $hospitalContact)
    {
        extract(request()->all());
        $hospitalContact->update(compact('name', 'phone', 'email', 'location'));

        return response()->json([
                'message' => 'Update Successful',
                'data' => $hospitalContact->fresh(),
            ]);
    }
}
