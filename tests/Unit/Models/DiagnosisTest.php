<?php

namespace Tests\Unit\Models;

use App\Models\Diagnosis;
use App\Models\MedicalRecord;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DiagnosisTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_diagnosis_belongs_to_a_medical_record()
    {
        $diagnosis = create(Diagnosis::class);
        $this->assertInstanceOf(MedicalRecord::class, $diagnosis->record);
    }

}
