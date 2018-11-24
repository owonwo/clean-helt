<?php

namespace App\Observers;

use App\Models\FamilyRecord;

class FamilyRecordObserver
{
    //
    public function retrieved(FamilyRecord $payload)
    {
        $payload->carriers = json_decode($payload->carriers);
        return $payload;
    }
}
