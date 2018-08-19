<?php

namespace App\Http\Controllers\API\Hospital;

use App\Filters\MedicalRecordsFilter;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MedicalRecordController extends Controller
{
    private $hospital;

    public function __construct()
    {
        $this->middleware('auth:hospital-api');
        $this->hospital = auth()->guard('hospital')->user();
    }

    public function index(Patient $patient, MedicalRecordsFilter $filters)
    {
        if (!$this->hospital->canViewProfile($patient))
            return response()->json(['message' => 'Unauthorized'], 401);

        $records = $patient->medicalRecords()
                        ->filter($filters)
                        ->latest()
                        ->paginate(30);

        return response()->json([
            'records' => $records
        ], 200);
    }

    public function show(Patient $patient, MedicalRecord $medicalRecord)
    {
        if (!$this->hospital->canViewProfile($patient))
            return response()->json(['message' => 'Unauthorized'], 401);

        return response()->json([
            'data' => $medicalRecord->load('data')
        ], 200);
    }
}
