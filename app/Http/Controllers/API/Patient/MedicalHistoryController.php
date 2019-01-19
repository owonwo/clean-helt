<?php
namespace App\Http\Controllers\API\Patient;

use App\Helpers\RecordLogger;
use App\Http\Controllers\Controller;
use App\Models\MedicalHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MedicalHistoryController extends Controller
{
    //
    use PatientRecords;

    protected $model = MedicalHistory::class;
    protected $rules = [
        'illness' => 'required',
        'date_of_onset' => 'required',
    ];

    public function store(RecordLogger $logger)
    {
        $patient = auth()->guard('patient-api')->user();

        try {
            $this->validate(request(), $this->rules);
            DB::beginTransaction();
            $record = $logger->logMedicalRecord($patient, $patient, 'medical-history');

            $medicalHistory = MedicalHistory::forceCreate([
                'record_id' => $record->id,
                'illness' => request('illness'),
                'date_of_onset' => request('date_of_onset'),
                'description' => request('description'),
            ]);
            DB::commit();

            return response()->json([
                'message' => 'Medical History created successfully',
                'data' => $medicalHistory->load('record'),
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
                'message' => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
    public function update(MedicalHistory $medicalHistory)
    {
        $medicalHistory->update([
            'illness' => request('illness'),
            'date_of_onset' => request('date_of_onset'),
            'description' => request('description'),
        ]);

        return response()->json([
            'message' => 'Update Successful',
            'data' => $medicalHistory,
        ], 200);
    }
}
