<?php

namespace App\Http\Controllers\API\Laboratory;

use App\Filters\MedicalRecordsFilter;
use App\Models\LabTest;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Notifications\PatientLaboratoryNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MedicalRecordController extends Controller
{
    private $laboratory;

    public function __construct()
    {
        $this->middleware('auth:laboratory-api');
        $this->middleware(function($request, $next) {
            $this->laboratory = auth()->user();

            return $next($request);
        });
    }

    public function index(Patient $patient, MedicalRecordsFilter $filters)
    {

        if ($patient->exists && $this->laboratory->canViewProfile($patient)) {
            $records = $patient->medicalRecords('App\Models\LabTest')
                                ->filter($filters)
                                ->latest()
                                ->paginate(30);

            return response()->json([
                'records' => $records
            ], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function show(Patient $patient, MedicalRecord $medicalRecord)
    {
        if (!$this->laboratory->canViewProfile($patient))
            return response()->json(['message' => 'Unauthorized'], 401);

        return response()->json([
            'record' => $medicalRecord,
            'data' => $medicalRecord->data,
        ], 200);
    }

    public function update(Patient $patient, MedicalRecord $medicalRecord, LabTest $labTest)
    {
        $laboratory = auth()->guard('laboratory-api')->user();
        if ($laboratory->canUpdatePatienLabTest($patient, $medicalRecord, $labTest)){

            return response()->json(['message' => 'Data not found'], 404);

        }else{

            $labTest->update(request()->all());
            $labTest->save();
            $laboratory->notify(new PatientLaboratoryNotification($patient, $labTest));
            return response()->json([
                'message' => 'Test successfully Carried out',
                'labtest' => $labTest,
                'record' => $medicalRecord
            ], 200);
        }


//        return response()->json([
//            'message' => 'labtest could not be carried out'
//        ], 400);
    }

    public function testrecord(Patient $patient, MedicalRecord $medicalRecord, LabTest $labTest)
    {
        request()->request->add(['status' => true]);
        return $this->update($patient, $medicalRecord, $labTest);
    }
}
