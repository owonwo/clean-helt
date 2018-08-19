<?php
/**
 * Created by PhpStorm.
 * User: chiemelachinedum
 * Date: 17/08/2018
 * Time: 1:05 PM
 */

namespace App\Filters;

class MedicalRecordsFilter extends Filter
{
    protected $filters = ['type', 'start_date', 'end_date'];

    public function type($value)
    {
        $type = $this->getRecordType($value);
        return $this->builder->where('type', $type);
    }

    public function start_date($startDate)
    {
        return $this->builder->whereDate('created_at', '>=', $startDate);
    }

    public function end_date($endDate)
    {
        return $this->builder->whereDate('created_at', '<=', $endDate);
    }

    protected function getRecordType($type)
    {
        switch ($type) {
            case 'prescription':
                return 'App\Models\Prescription';
            case 'diagnosis':
                return 'App\Models\Diagnosis';
            case 'tests':
                return 'App\Models\LabTest';
            default:
                return null;
        }
    }
}