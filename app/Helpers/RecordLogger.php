<?php
/**
 * Created by PhpStorm.
 * User: chiemelachinedum
 * Date: 11/08/2018
 * Time: 6:59 PM
 */

namespace App\Helpers;

use App\Models\MedicalRecord;

class RecordLogger
{
    public function logMedicalRecord($patient, $issuer, $type)
    {
        $recordData = [
            'patient_id' => $patient->id,
            'type' => $this->getRecordType($type),
            'issuer_type' => get_class($issuer),
            'issuer_id' => $issuer->id
        ];

        return MedicalRecord::create($recordData);
    }

    private function getRecordType($type)
    {
        switch ($type) {
            case 'diagnosis':
                return 1;
            case 'prescription':
                return 2;
            case 'test':
            default:
                return 3;
        }
    }
}