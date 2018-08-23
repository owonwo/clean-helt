<?php
/**
 * Created by PhpStorm.
 * User: Tammy
 * Date: 18/08/2018
 * Time: 22:39
 */

namespace App\Filters;



use App\Models\Doctor;

class PatientFilter extends Filters
{
    protected $filters = ['dateRange'];

    public function dateRange($start,$end){
        $doctor = new Doctor();
        return $doctor->profileShares()->whereBetween('expired_at',[$start,$end])->get();
    }

}