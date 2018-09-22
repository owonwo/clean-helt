<?php

namespace Tests\Feature\Patient;

use App\Models\Contact;
use App\Models\Doctor;
use App\Models\Patient;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PatientManagesContactsTest extends TestCase
{
    use RefreshDatabase;

    private $patient;

    protected function setUp()
    {
        parent::setUp();
        $this->patient = create(Patient::class);
        $this->signIn($this->patient, "patient");
    }

    /** @test */
    public function a_patient_can_view_all_contacts()
    {
        $doctor = create(Doctor::class);

        $this->patient->contacts()->create([
            'contact_id' => $doctor->id,
            'contact_type' => get_class($doctor)
        ]);

        $this->makeAuthRequest()
            ->get("api/patient/contacts")
            ->assertSee($doctor->first_name);
    }

    /** @test */
    public function a_patient_can_add_a_contact()
    {
        $doctor = create(Doctor::class);

        $this->makeAuthRequest()
            ->post("api/patient/contacts", ['chcode' => $doctor->chcode]);

        $this->assertDatabaseHas('contacts', [
            'contact_id' => $doctor->id,
            'contact_type' => get_class($doctor),
            'owner_id' => $this->patient->id,
            'owner_type' => get_class($this->patient)
        ]);
    }

    /** @test */
    public function a_patient_cannot_add_a_contact_twice()
    {
        $doctor = create(Doctor::class);

        $this->patient->contacts()->create([
            'contact_id' => $doctor->id,
            'contact_type' => get_class($doctor)
        ]);

        $this->makeAuthRequest()
            ->post("api/patient/contacts", ['chcode' => $doctor->chcode])
            ->assertStatus(400);
    }

    /** @test */
    public function a_patient_can_delete_a_contact()
    {
        $doctor = create(Doctor::class);

        $contact = $this->patient->contacts()->create([
            'contact_id' => $doctor->id,
            'contact_type' => get_class($doctor)
        ]);

        $this->makeAuthRequest()
            ->delete("api/patient/contacts/{$contact->id}")
            ->assertStatus(200);

        $this->assertDatabaseMissing('contacts', [
            'contact_id' => $doctor->id,
            'contact_type' => get_class($doctor),
            'owner_id' => $this->patient->id,
            'owner_type' => get_class($this->patient)
        ]);
    }

    /** @test */
    public function a_patient_cannot_delete_a_contact_he_does_not_own()
    {
        $doctor = create(Doctor::class);

        $contact = create(Contact::class, [
            'owner_id' => 200,
            'contact_id' => $doctor->id,
            'contact_type' => get_class($doctor)
        ]);

        $this->makeAuthRequest()
            ->delete("api/patient/contacts/{$contact->id}")
            ->assertStatus(404);

        $this->assertDatabaseHas('contacts', [
            'contact_id' => $doctor->id,
            'contact_type' => get_class($doctor),
            'owner_id' => 200,
            'owner_type' => get_class($this->patient)
        ]);
    }
}
