<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;




class MedicalRecordTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_medical_record_belongs_to_a_patient()
    {
        $record = create('App\Models\MedicalRecord');
        $this->assertInstanceOf('App\Models\Patient',$record->patient);
    }
    public function a_medical_record_has_an_issuer(){
        $record = create('App\Models\MedicalRecord');

    }
}
