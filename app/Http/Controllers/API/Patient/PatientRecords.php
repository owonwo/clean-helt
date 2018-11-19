<?php
namespace App\Http\Controllers\API\Patient;

trait PatientRecords
{
    public function index()
    {
        $patient = auth()->guard('patient-api')->user();
        return response()->json([
            'data' => $this->model::orderByDesc('id')->get()->toArray()
        ]);
    }
}
