<?php

namespace Tests\Feature\Patient;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\ProfileShare;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PatientSharesProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_patient_can_share_his_profile_to_anyone()
    {
        $patient = create(Patient::class);
        $provider = create(Doctor::class);
        $this->signIn($patient, 'patient');
        $this->makeAuthRequest()
            ->post(route('patient.profile.share'), [
                'chcode' => $provider->chcode,
                'expiration' => Carbon::now()->addDay(1)->format('Y-m-d h:i:s')
            ]);

        $this->assertDatabaseHas('profile_shares', [
            'patient_id' => $patient->id,
            'provider_id' => $provider->id,
            'provider_type' => get_class($provider),
            'doctor_id' => $provider->id,
        ]);
    }

    /** @test */
    public function a_patient_can_not_share_his_profile_with_a_date_lesser_than_now()
    {
        $patient = create(Patient::class);

        $provider = create(Doctor::class);

        $this->signIn($patient, 'patient');

        $this->expectException(ValidationException::class);

        $this->makeAuthRequest()
            ->post('/api/patient/profile/shares', [
                'chcode' => $provider->chcode,
                'expiration' => Carbon::now()->subDay()->format('Y-m-d h:i:s')
            ]);
    }

    /** @test */
    public function a_patient_can_view_a_log_of_his_profile_shares()
    {
        $patient = create(Patient::class);

        $shareOne = create(ProfileShare::class, ['patient_id' => $patient->id]);

        $this->signIn($patient, 'patient');

        $this->makeAuthRequest()
            ->get('/api/patient/profile/shares')
            ->assertSee($shareOne->patient_id);
    }

    /** @test */
    public function a_patient_can_expire_a_share()
    {
        $patient = create(Patient::class);

        $shareOne = create(ProfileShare::class, ['patient_id' => $patient->id]);

        $this->signIn($patient, 'patient');

        $this->makeAuthRequest()
            ->patch("/api/patient/profile/shares/{$shareOne->id}/expire");

        $this->assertFalse($shareOne->fresh()->isActive);
    }

    /** @test */
    public function a_patient_can_extend_a_share()
    {
        $patient = create(Patient::class);

        $shareOne = create(ProfileShare::class, ['patient_id' => $patient->id]);

        $this->signIn($patient, 'patient');

        // New expiration
        $expiration = $shareOne->expired_at->addDays(1)->format('Y-m-d h:i:s');

        $update = ['extension' => $expiration];

        $this->makeAuthRequest()
            ->patch("/api/patient/profile/shares/{$shareOne->id}/extend", $update);

        $this->assertDatabaseHas('profile_shares',['expired_at' => $update]);
    }
}
