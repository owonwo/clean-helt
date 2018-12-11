<?php

namespace App\Http\Controllers\API\Patient;

trait PatientRecords
{
    /**
     * Fetches all medicalrecord for auth:user
     *
     * @return JsonResponse
     **/
    public function index()
    {
        $patient = auth()->guard('patient-api')->user();
        $data = $patient->medicalRecords($this->model)->get()
            ->each(function ($record) {
                $record->data;
            });

        return response()->json(compact('data'));
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
        if ($model->record) {
            $model->record->delete();
        }
        if ($model->delete()) {
            return response()->json([
                'data' => "Record Deleted for [{$this->model}]",
            ]);
        }

        return response()->json([
            'message' => "Record not delete from [{$this->model}]",
        ], 422);
    }
}
