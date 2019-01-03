<?php
/**
 * Created by PhpStorm.
 * User: chiemelachinedum
 * Date: 11/08/2018
 * Time: 6:59 PM
 */
namespace App\Helpers;

use App\Models\MedicalRecord;
use App\Models\Patient;

class RecordLogger
{
    // $patient param collects the patient
    // $issuer collects the model  for the person who issued the record
    // $type  checks if it is a diagnosis,prescription,test
    public function logMedicalRecord(Patient $patient, $issuer, $type)
    {
        $recordData = [
            'patient_id' => $patient->id,
            'type' => $this->getRecordType($type),
            'issuer_type' => get_class($issuer),
            'issuer_id' => $issuer->id, //
        ];

        return MedicalRecord::create($recordData);
    }

    //Gets the Record type for the patient
    private function getRecordType($type)
    {
        switch ($type) {
            case 'diagnosis':
                return \App\Models\Diagnosis::class;
            case 'prescription':
                return \App\Models\Prescription::class;
            case 'test':
                return \App\Models\LabTest::class;
            case 'immunization':
                return \App\Models\Immunization::class;
            case 'allergy':
                return \App\Models\Allergy::class;
            case 'medical-history':
                return \App\Models\MedicalHistory::class;
            case 'health-insurance':
                return \App\Models\HealthInsurance::class;
            case 'family-medical-history':
                return \App\Models\FamilyRecord::class;
            case 'hospital-contact':
                return \App\Models\HospitalContacts::class;
            case 'emergency-contact':
                return \App\Models\EmergencyContact::class;
            case 'hospitalization':
                return \App\Models\Hospitalize::class;
            case 'checkup':
                return \App\Models\MedicalCheckup::class;
            case 'medications':
                return \App\Models\Medication::class;
            default:
                return \App\Models\Diagnosis::class;
        }
    }
}
