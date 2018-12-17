<?php

namespace Tests\Unit\Models;

use App\Models\MedicalRecord;
use App\Models\MedicalCheckup;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MedicalCheckupTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_medical_checkup_belongs_to_a_medical_record()
    {
        $checkup = create(MedicalCheckup::class);
        $this->assertInstanceOf(MedicalRecord::class, $checkup->record);
    }
}
