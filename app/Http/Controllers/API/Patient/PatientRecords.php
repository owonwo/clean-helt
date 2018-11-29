<?php

namespace App\Http\Controllers\API\Patient;

trait PatientRecords
{
    public function index()
    {
        $patient = auth()->guard('patient-api')->user();

        return response()->json([
              'data' =>$patient->medicalRecords($this->model)->get()->load('data')
        ]);
    }

    /**
     * Deletes a model.
     *
     * @param int $id 
     *
     * @return Json
     **/
    public function destroy($id)
    {
        $model = $this->model::findOrFail($id);
        if ($model->delete()) {
            return response()->json([
                'data' => 'Record Deleted',
            ]);
        } else {
            return response()->json([
                'message' => 'Record not delete from '.$this->model,
            ], 422);
        }
    }
}
