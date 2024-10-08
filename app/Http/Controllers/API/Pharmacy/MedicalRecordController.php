<?php

namespace App\Http\Controllers\API\Pharmacy;

use App\Filters\MedicalRecordsFilter;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Prescription;
use App\Notifications\PatientPrescriptionNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MedicalRecordController extends Controller
{
    private $pharmacy;

    public function __construct()
    {
        $this->middleware('auth:pharmacy-api');
        $this->middleware(function ($request, $next) {
            $this->pharmacy = auth()->user();

            return $next($request);
        });
    }

    public function index(Patient $patient, MedicalRecordsFilter $filters)
    {
        if ($patient->exists && $this->pharmacy->canViewProfile($patient)) {
            $records = $patient->medicalRecords('App\Models\Prescription')
                                // ->filter($filters)
                                ->latest()
                                ->paginate(30);
            $records->each(function ($record) {
                return $record->data;
            });

            return response()->json($records, 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function show(Patient $patient, MedicalRecord $medicalRecord)
    {
        if (!$this->pharmacy->canViewProfile($patient)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json([
            'record' => $medicalRecord,
            'data' => $medicalRecord->data,
        ], 200);
    }

    public function update(Patient $patient, MedicalRecord $medicalRecord, Prescription $prescription)
    {
        if (!$this->pharmacy->canUpdatePatientPrescription($patient, $medicalRecord, $prescription)) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $this->pharmacy->notify(new PatientPrescriptionNotification($patient, $prescription));

        if ($prescription->update(request()->all())) {
            return response()->json([
                'message' => 'Prescription dispensed successfully',
                'prescription' => $prescription->fresh(),
                'record' => $medicalRecord,
            ], 200);
        }

        return response()->json([
            'message' => 'Prescription could not be dispensed',
        ], 400);
    }

    public function dispense(Patient $patient, MedicalRecord $medicalRecord, Prescription $prescription)
    {
        request()->request->add(['status' => true]);

        return $this->update($patient, $medicalRecord, $prescription);
    }
}
