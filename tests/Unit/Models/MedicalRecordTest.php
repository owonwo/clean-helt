<?php

namespace Tests\Unit\Models;

use App\Models\MedicalRecord;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MedicalRecordTest extends TestCase
{
    use RefreshDatabase;

    private $record;

    protected function setUp()
    {
        parent::setUp();
        $this->record = create(MedicalRecord::class);
    }

    /** @test */
    public function a_medical_record_belongs_to_a_patient()
    {
        $this->assertInstanceOf('App\Models\Patient',$this->record->patient);
    }

    /** @test */
    public function a_medical_record_generates_its_own_reference_code()
    {
        $this->assertNotNull($this->record->reference);
    }

    /** @test */
    public function a_medical_record_has_associated_data()
    {
        $this->assertInstanceOf(Collection::class, $this->record->data);
    }
}
